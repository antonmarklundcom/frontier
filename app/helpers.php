<?php
declare(strict_types=1);

/** Site configuration value. */
function site(string $key, mixed $default = null): mixed
{
    return $GLOBALS['PF_SITE'][$key] ?? $default;
}

/**
 * Emit trusted markup without escaping it.
 *
 * This is the site's entire raw-HTML trust boundary, and it is a function
 * rather than a bare `<?= $value ?>` for one reason: a bare echo is invisible.
 * `grep -rn '<?=' app/templates | grep -v 'e(' | grep -v 'raw_html('` is the
 * audit, and it must come back empty. A reviewer can then ask the only
 * question that matters — "where did this string come from?" — at the small
 * number of places where the answer can be anything other than 'it was
 * escaped'.
 *
 * The contract, and it is narrow: the value must come from a content file in
 * `app/content/`, written by an author with commit access, and the key must
 * end in `_html` so that the trust is visible at the data as well as at the
 * template. It must never carry anything a visitor supplied. Content files
 * hold markup at all only so prose can contain inline emphasis and links;
 * nothing in this codebase renders visitor input as HTML, and nothing should
 * start.
 *
 * Arrays are rejected rather than coerced: a template passing an array here
 * would previously have echoed the word "Array" into the page.
 */
function raw_html(mixed $value): string
{
    if ($value === null) {
        return '';
    }
    if (!is_scalar($value)) {
        // Loud in the log, silent on the page. Emitting "Array" to a visitor
        // is worse than emitting nothing, and throwing would take down a page
        // over a content typo.
        error_log('raw_html() received ' . get_debug_type($value) . ', expected a string');
        return '';
    }
    return (string) $value;
}

/** Escape for HTML text and attribute contexts. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * True when a configured value is still an unresolved placeholder.
 * Placeholders are never rendered to visitors — the surrounding UI is omitted
 * instead, so the site can never display "[WHATSAPP_NUMBER]" to a prospect.
 */
function is_placeholder(mixed $value): bool
{
    return !is_string($value) || $value === '' || (bool) preg_match('/^\[[A-Z0-9_]+\]$/', $value);
}

/** Configured value, or null when it is still a placeholder. */
function real(string $key): ?string
{
    $v = site($key);
    return is_placeholder($v) ? null : (string) $v;
}

/** Absolute URL for a site-relative path. */
function url(string $path = '/'): string
{
    return rtrim((string) site('base_url'), '/') . '/' . ltrim($path, '/');
}

/** Site-relative href, always with a trailing slash except for files. */
function href(string $path): string
{
    if ($path === '' || $path[0] === '#' || str_starts_with($path, 'http') || str_starts_with($path, 'mailto:') || str_starts_with($path, 'tel:')) {
        return $path;
    }
    $path = '/' . trim($path, '/');
    if ($path === '/') {
        return '/';           // the root is already its own trailing slash
    }
    return str_contains(basename($path), '.') ? $path : $path . '/';
}

/** Cache-busted asset path. */
function asset(string $path): string
{
    $rel = '/' . ltrim($path, '/');
    $abs = PF_ROOT . $rel;
    return is_file($abs) ? $rel . '?v=' . substr((string) filemtime($abs), -6) : $rel;
}

/** Render a template partial or block with $data in scope. */
function partial(string $name, array $data = []): void
{
    $file = PF_APP . '/templates/' . $name . '.php';
    if (!is_file($file)) {
        return;
    }
    extract($data, EXTR_SKIP);
    require $file;
}

/** Human-readable review date, e.g. "12 August 2026". */
function review_date(?string $iso): string
{
    if (!$iso) {
        return '';
    }
    $d = DateTimeImmutable::createFromFormat('Y-m-d', $iso);
    return $d ? $d->format('j F Y') : $iso;
}

/**
 * WhatsApp deep link with a self-attributing prefilled message, so a shared
 * number still tells you which page produced the conversation.
 */
function whatsapp_link(string $context = ''): ?string
{
    $number = real('whatsapp');
    if (!$number) {
        return null;
    }
    // The greeting is a whole sentence in the content layer, not a sentence
    // assembled here from fragments: word order differs between languages, so
    // concatenating around a variable is the one shape a translator cannot fix.
    $msg = $context !== ''
        ? t_format('whatsapp_greeting_context', $context)
        : t('whatsapp_greeting');
    return 'https://wa.me/' . preg_replace('/\D+/', '', $number) . '?text=' . rawurlencode($msg);
}
