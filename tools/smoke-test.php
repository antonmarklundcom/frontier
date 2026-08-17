<?php
/**
 * Hits every registered URL over HTTP against a real server and reports what
 * came back. Use it immediately after a deploy — it is the only way to verify
 * the .htaccess rewrite rules, which cannot be tested by the built-in PHP
 * server (it ignores .htaccess entirely).
 *
 *   php tools/smoke-test.php https://staging.paraguayfrontier.com
 *   php tools/smoke-test.php http://127.0.0.1:8080     (app only, no rewrites)
 *
 * Exit code 1 if any route fails.
 */

declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';

$base = rtrim($argv[1] ?? '', '/');
if ($base === '') {
    fwrite(STDERR, "usage: php tools/smoke-test.php https://host\n");
    exit(2);
}
$live = str_starts_with($base, 'https://');

function fetch(string $url): array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,   // redirects are the thing being tested
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_USERAGENT      => 'paraguay-frontier-smoke-test',
        CURLOPT_HEADER         => true,
        CURLOPT_NOBODY         => false,
    ]);
    $raw  = curl_exec($ch);
    $err  = curl_error($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $hlen = (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);
    if ($raw === false) { return ['code' => 0, 'headers' => '', 'body' => '', 'error' => $err]; }
    return [
        'code'    => $code,
        'headers' => substr($raw, 0, $hlen),
        'body'    => substr($raw, $hlen),
        'error'   => '',
    ];
}

$fail = 0;

// The two error pages send their own status deliberately — a 404 document that
// answers 200 is worse than no 404 document at all.
$expectedStatus = ['error-404' => 404, 'error-500' => 500];

echo "\n== Routes ==  ($base)\n";
foreach (registry() as $id => $entry) {
    $want = $expectedStatus[$id] ?? 200;
    $r = fetch($base . $entry['url']);
    $good = $r['code'] === $want;
    if (!$good) { $fail++; }
    printf("  %s  %-3d %s%s%s\n",
        $good ? 'ok  ' : 'FAIL',
        $r['code'],
        $entry['url'],
        $want !== 200 ? "  (expected $want)" : '',
        $r['error'] ? "  ({$r['error']})" : '');

    if ($good && preg_match('/\[[A-Z][A-Z0-9_]{3,}\]/', strip_tags($r['body']), $m)) {
        echo "  FAIL  placeholder {$m[0]} reached the visitor on {$entry['url']}\n";
        $fail++;
    }
}

// .htaccess is honoured by Apache and by LiteSpeed (what Hostinger shared
// hosting actually runs). PHP's built-in server ignores it completely, so the
// rules below are reported but not counted when there is no such server.
$probe        = fetch($base . '/');
$htaccessHost = (bool) preg_match('/^Server:.*(Apache|LiteSpeed)/mi', $probe['headers']);

echo "\n== Rewrite rules (.htaccess) ==" . ($htaccessHost ? "\n" : "   [not enforced by this server — reported only]\n");
$checks = [
    // path                       expected code(s)          what it proves
    ['/about',                    [301],  'no-slash URL redirects to the slashed one'],
    ['/app/bootstrap.php',        [403],  '/app is not reachable over HTTP'],
    ['/config/site.example.php',  [403],  '/config is not reachable over HTTP'],
    ['/tools/qa.php',             [403, 404], '/tools is not reachable over HTTP'],
    ['/docs/QA-REPORT.md',        [403, 404], 'internal docs are not served'],
    ['/no-such-page/',            [404],  'unknown URL returns 404, not 500'],
];
foreach ($checks as [$path, $expect, $why]) {
    $r = fetch($base . $path);
    $good = in_array($r['code'], $expect, true);
    if (!$good && $htaccessHost) { $fail++; }
    printf("  %s  %-3d %-28s %s\n",
        $good ? 'ok  ' : ($htaccessHost ? 'FAIL' : 'skip'), $r['code'], $path, $why);
}

if ($live) {
    echo "\n== HTTPS and canonical host ==\n";
    $http = fetch('http://' . parse_url($base, PHP_URL_HOST) . '/');
    $ok = $http['code'] === 301 && stripos($http['headers'], 'Location: https://') !== false;
    if (!$ok) { $fail++; }
    printf("  %s  %-3d http:// redirects to https://\n", $ok ? 'ok  ' : 'FAIL', $http['code']);
} else {
    echo "\n  note  HTTPS and host-canonicalisation checks skipped (base URL is not https).\n";
}
if (!$htaccessHost) {
    echo "  note  No Apache/LiteSpeed detected. .htaccess is not being applied, so the\n";
    echo "        rewrite, deny and header rules can only be verified on real hosting.\n";
}

echo "\n== Headers on / ==\n";
$home = $probe;
foreach (['X-Content-Type-Options', 'Referrer-Policy', 'Content-Security-Policy', 'X-Frame-Options'] as $h) {
    $present = stripos($home['headers'], $h . ':') !== false;
    printf("  %s  %s\n", $present ? 'ok  ' : 'warn', $h);
}
$noindex = stripos($home['body'], 'noindex') !== false;
printf("  %s  home page is %s\n", 'note', $noindex ? 'noindex (pre-launch, correct)' : 'INDEXABLE — confirm this is intended');

echo "\n" . str_repeat('-', 64) . "\n";
printf("%d failure(s)\n", $fail);
exit($fail > 0 ? 1 : 0);
