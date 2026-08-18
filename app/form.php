<?php
declare(strict_types=1);

/**
 * Consultation enquiry pipeline: browser → this handler → email + VenderCRM.
 *
 * Deliberate properties:
 *  - No third-party form service, so the message never passes through a system
 *    the privacy page would have to disclose.
 *  - The CRM key lives in config/env.php on the server and is used server-side
 *    only. Nothing in assets/ ever sees it (tools/qa.php checks).
 *  - POST-redirect-GET: a refresh after submitting cannot resend an enquiry.
 *  - Four independent spam defences, none of which are a CAPTCHA: same-origin
 *    CSRF token, honeypot field, minimum completion time, per-IP rate limit.
 *  - The form renders as disabled with an honest explanation until a delivery
 *    address is configured, because a form that silently discards enquiries is
 *    worse than no form. See docs/PRODUCTION-DATA-REQUIRED.md item 8.
 *
 * NOT YET VERIFIED: no message has been sent or received through this code on
 * real hosting. Until that happens, nothing on the site may claim the form works.
 */

const PF_FORM_MIN_SECONDS = 4;      // faster than this is a bot, not a typist
const PF_FORM_MAX_PER_HOUR = 5;     // per IP
const PF_FORM_TTL          = 7200;  // a form older than 2h is stale, not a bot

/** Server-side environment (SMTP + CRM). Never exposed to a template. */
function env_config(): array
{
    static $env = null;
    if ($env === null) {
        $file = PF_ROOT . '/config/env.php';
        $env = is_file($file) ? require $file : require PF_ROOT . '/config/env.example.php';
    }
    return $env;
}

function env_value(string $key): string
{
    return (string) (env_config()[$key] ?? '');
}

/**
 * The form accepts submissions only when there is somewhere for them to go.
 * Both a delivery address and a session mechanism are required.
 */
function form_enabled(): bool
{
    return env_value('mail_to') !== '' && env_value('smtp_host') !== '';
}

function pf_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE || headers_sent()) {
        return;
    }
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => (($_SERVER['HTTPS'] ?? '') !== '' || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'),
    ]);
    session_name('pfsess');
    session_start();
}

function csrf_token(): string
{
    pf_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['csrf'];
}

/** Signed "form was rendered at" stamp, so the minimum-time check needs no state. */
function form_stamp(): string
{
    $t = (string) time();
    return $t . '.' . hash_hmac('sha256', $t, form_secret());
}

function form_secret(): string
{
    pf_session();
    if (empty($_SESSION['form_secret'])) {
        $_SESSION['form_secret'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['form_secret'];
}

function stamp_age(string $stamp): ?int
{
    $parts = explode('.', $stamp, 2);
    if (count($parts) !== 2 || !ctype_digit($parts[0])) {
        return null;
    }
    if (!hash_equals(hash_hmac('sha256', $parts[0], form_secret()), $parts[1])) {
        return null;
    }
    return time() - (int) $parts[0];
}

/** Writable state directory, created on demand and blocked from the web. */
function storage_dir(): string
{
    $dir = PF_ROOT . '/storage';
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }
    if (!is_file($dir . '/.htaccess')) {
        @file_put_contents($dir . '/.htaccess', "Require all denied\n");
    }
    return $dir;
}

function client_ip(): string
{
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

/** Crude per-IP hourly limit. Enough to stop a script, cheap enough for shared hosting. */
function rate_limited(): bool
{
    $file = storage_dir() . '/rate-' . substr(hash('sha256', client_ip()), 0, 16) . '.json';
    $now  = time();
    $hits = is_file($file) ? (array) json_decode((string) file_get_contents($file), true) : [];
    $hits = array_values(array_filter($hits, fn($t) => is_int($t) && $t > $now - 3600));
    if (count($hits) >= PF_FORM_MAX_PER_HOUR) {
        return true;
    }
    $hits[] = $now;
    @file_put_contents($file, json_encode($hits), LOCK_EX);
    return false;
}

/**
 * Validate and dispatch a consultation enquiry, then redirect. Called from the
 * route entrypoint before any output, so it can always send headers.
 */
function handle_consultation_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        return;
    }
    pf_session();

    $old = [
        'name'    => trim((string) ($_POST['name'] ?? '')),
        'email'   => trim((string) ($_POST['email'] ?? '')),
        'country' => trim((string) ($_POST['country'] ?? '')),
        'stage'   => trim((string) ($_POST['stage'] ?? '')),
        'message' => trim((string) ($_POST['message'] ?? '')),
    ];
    $errors = [];

    if (!form_enabled()) {
        $errors['form'] = 'This form is not accepting submissions yet.';
    }
    if (!hash_equals((string) ($_SESSION['csrf'] ?? ''), (string) ($_POST['csrf'] ?? ''))) {
        $errors['form'] = 'Your session expired before the form was sent. Please try again.';
    }
    // Honeypot: a real browser leaves this empty because it is hidden from it.
    if (trim((string) ($_POST['company_website'] ?? '')) !== '') {
        $errors['form'] = 'This message could not be sent.';
    }
    $age = stamp_age((string) ($_POST['stamp'] ?? ''));
    if ($age === null || $age < PF_FORM_MIN_SECONDS || $age > PF_FORM_TTL) {
        $errors['form'] = 'This message could not be sent. Please reload the page and try again.';
    }
    if ($errors === [] && rate_limited()) {
        $errors['form'] = 'Several messages have already been sent from this connection. Please email us instead.';
    }

    if ($old['name'] === '') {
        $errors['name'] = 'Please tell us what to call you.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'We need a working email address to reply to.';
    }
    if (mb_strlen($old['message']) < 20) {
        $errors['message'] = 'A sentence or two about your situation helps us prepare. 20 characters minimum.';
    }
    if (mb_strlen($old['message']) > 4000) {
        $errors['message'] = 'That is longer than this form accepts. Please send the detail by email.';
    }

    if ($errors !== []) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_old']    = $old;
        redirect(href(page_url('book')) . '#enquiry');
    }

    $delivered = deliver_enquiry($old);
    if (!$delivered) {
        $_SESSION['form_errors'] = ['form' => 'We could not send your message. Please email us directly — nothing was lost on your side.'];
        $_SESSION['form_old']    = $old;
        redirect(href(page_url('book')) . '#enquiry');
    }

    unset($_SESSION['form_errors'], $_SESSION['form_old'], $_SESSION['csrf']);
    redirect(href(page_url('thank-you')));
}

function redirect(string $to): never
{
    if (!headers_sent()) {
        header('Location: ' . $to, true, 303);
    }
    exit;
}

/**
 * Deliver to the inbox first, then to the CRM. Email is the system of record:
 * a CRM failure must never lose an enquiry, so its result does not gate success.
 */
function deliver_enquiry(array $data): bool
{
    $lines = [
        'Name:      ' . $data['name'],
        'Email:     ' . $data['email'],
        'Country:   ' . ($data['country'] !== '' ? $data['country'] : '—'),
        'Stage:     ' . ($data['stage'] !== '' ? $data['stage'] : '—'),
        'Received:  ' . gmdate('c'),
        'Page:      ' . url(page_url('book')),
        '',
        $data['message'],
    ];
    $sent = smtp_send(
        env_value('mail_from'),
        env_value('mail_to'),
        'Consultation enquiry — ' . $data['name'],
        implode("\n", $lines),
        $data['email']
    );

    if (env_config()['crm_enabled'] ?? false) {
        crm_push($data);   // best effort; failure is logged, not surfaced
    }

    return $sent;
}

/**
 * Minimal authenticated SMTP submission over STARTTLS.
 * No Composer on this host, and mail() on shared hosting lands in spam folders,
 * so this speaks the protocol directly. Returns false on any protocol failure.
 */
function smtp_send(string $from, string $to, string $subject, string $body, string $replyTo = ''): bool
{
    $host = env_value('smtp_host');
    $port = (int) (env_value('smtp_port') ?: 587);
    $user = env_value('smtp_user');
    $pass = env_value('smtp_pass');
    if ($host === '' || $to === '' || $from === '') {
        return false;
    }

    $sock = @stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, 15);
    if (!$sock) {
        error_log("PF form: SMTP connect failed: {$errstr}");
        return false;
    }
    stream_set_timeout($sock, 15);

    $read = function () use ($sock): string {
        $out = '';
        while (($line = fgets($sock, 515)) !== false) {
            $out .= $line;
            if (strlen($line) < 4 || $line[3] !== '-') {
                break;
            }
        }
        return $out;
    };
    $cmd = function (string $line, string $expect) use ($sock, $read): bool {
        fwrite($sock, $line . "\r\n");
        $res = $read();
        if (!str_starts_with($res, $expect)) {
            error_log('PF form: SMTP unexpected reply to ' . strtok($line, ' ') . ': ' . trim($res));
            return false;
        }
        return true;
    };

    $ok = str_starts_with($read(), '220')
        && $cmd('EHLO ' . (parse_url((string) site('base_url'), PHP_URL_HOST) ?: 'localhost'), '250')
        && $cmd('STARTTLS', '220');
    if ($ok) {
        $ok = (bool) @stream_socket_enable_crypto($sock, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
    }
    if ($ok) {
        $ok = $cmd('EHLO ' . (parse_url((string) site('base_url'), PHP_URL_HOST) ?: 'localhost'), '250');
    }
    if ($ok && $user !== '') {
        $ok = $cmd('AUTH LOGIN', '334')
            && $cmd(base64_encode($user), '334')
            && $cmd(base64_encode($pass), '235');
    }

    $headers = [
        'From: Paraguay Frontier <' . $from . '>',
        'To: <' . $to . '>',
        'Subject: ' . mb_encode_mimeheader($subject, 'UTF-8'),
        'Date: ' . date(DATE_RFC2822),
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
    ];
    if ($replyTo !== '') {
        $headers[] = 'Reply-To: <' . $replyTo . '>';
    }
    // Dot-stuffing: a line that is a single dot would otherwise end the message.
    $data = implode("\r\n", $headers) . "\r\n\r\n"
          . preg_replace('/^\./m', '..', str_replace("\n", "\r\n", $body));

    if ($ok) {
        $ok = $cmd('MAIL FROM:<' . $from . '>', '250')
            && $cmd('RCPT TO:<' . $to . '>', '250')
            && $cmd('DATA', '354')
            && $cmd($data . "\r\n.", '250');
    }
    @$cmd('QUIT', '221');
    fclose($sock);

    return $ok;
}

/**
 * Push the enquiry to VenderCRM as a contact + pipeline deal.
 * Best effort by design: the email above is the system of record.
 */
function crm_push(array $data): bool
{
    $endpoint = env_value('crm_endpoint');
    $key      = env_value('crm_key');
    if ($endpoint === '' || $key === '') {
        return false;
    }
    $payload = json_encode([
        'name'    => $data['name'],
        'email'   => $data['email'],
        'country' => $data['country'],
        'stage'   => $data['stage'],
        'message' => $data['message'],
        'source'  => env_config()['crm_source'] ?? 'site',
        'page'    => url(page_url('book')),
    ], JSON_UNESCAPED_UNICODE);

    $ctx = stream_context_create(['http' => [
        'method'        => 'POST',
        'header'        => "Content-Type: application/json\r\nAuthorization: Bearer {$key}\r\n",
        'content'       => $payload,
        'timeout'       => 8,
        'ignore_errors' => true,
    ]]);
    $res = @file_get_contents($endpoint, false, $ctx);
    if ($res === false) {
        error_log('PF form: CRM push failed (enquiry was still emailed)');
        return false;
    }
    return true;
}

/** Errors and previous input from a failed submission, cleared once read. */
function form_state(): array
{
    if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
        pf_session();
    }
    $state = [
        'errors' => (array) ($_SESSION['form_errors'] ?? []),
        'old'    => (array) ($_SESSION['form_old'] ?? []),
    ];
    unset($_SESSION['form_errors'], $_SESSION['form_old']);
    return $state;
}
