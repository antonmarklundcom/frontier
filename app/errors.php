<?php
declare(strict_types=1);

/**
 * Production error handling.
 *
 * A visitor to a legal-services site must never see a stack trace. A trace
 * names file paths, library versions and — in the wrong exception — the
 * arguments a function was called with, which on this site can include a
 * prospect's message or a CRM key. It also reads as a broken business.
 *
 * So: display nothing, log everything, and render the site's own 500 page
 * with a real 500 status so crawlers treat it as an outage rather than as
 * content.
 *
 * Web requests only. Under CLI (tools/qa.php, tools/build-release.php and
 * the rest of the build gate) PHP's default behaviour is exactly what is
 * wanted — a loud trace on the terminal of the person who broke it — and an
 * HTML error page written to stdout would corrupt tool output.
 */

/** True once a handler is rendering, so a failure inside it cannot loop. */
$GLOBALS['PF_HANDLING_ERROR'] = false;

/** Fatal error types: those that end the request without an exception. */
const PF_FATAL_ERRORS = E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING
    | E_COMPILE_ERROR | E_COMPILE_WARNING | E_USER_ERROR;

/**
 * Render the site's 500 page, or the smallest possible fallback if even that
 * fails. Never echoes anything derived from the error.
 */
function pf_render_error_page(): void
{
    if ($GLOBALS['PF_HANDLING_ERROR']) {
        return;                 // already rendering; a second failure is fatal
    }
    $GLOBALS['PF_HANDLING_ERROR'] = true;

    // Whatever half-written markup the request produced is not a page. Drop it
    // so the visitor gets the error page and not a truncated one glued to it.
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (headers_sent()) {
        // The status line is already gone. Nothing can be done about the code;
        // say something honest rather than leaving a page cut off mid-sentence.
        echo "\n<!-- request failed -->\n";
        return;
    }

    http_response_code(500);

    try {
        render_page('error-500', 500);
    } catch (Throwable) {
        // The renderer itself is broken — the content registry, a template or
        // the config. Hardcoded, dependency-free, and deliberately terse.
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8">'
            . '<meta name="robots" content="noindex"><title>Something went wrong</title>'
            . '</head><body><h1>Something went wrong</h1>'
            . '<p>This page could not be displayed. The problem is on our side '
            . 'and has been logged.</p><p><a href="/">Return to the home page</a></p>'
            . '</body></html>';
    }
}

/** One log line per failure, with enough to find it and nothing to leak. */
function pf_log_failure(string $kind, string $message, string $file, int $line): void
{
    error_log(sprintf(
        'paraguay-frontier %s: %s in %s:%d [%s %s]',
        $kind,
        $message,
        $file,
        $line,
        $_SERVER['REQUEST_METHOD'] ?? '-',
        $_SERVER['REQUEST_URI'] ?? '-'
    ));
}

if (PHP_SAPI !== 'cli') {
    // Report everything to the log; show nothing to the visitor. These are set
    // here rather than trusted from php.ini because shared hosting defaults
    // vary, and "display_errors was On in production" is the exact accident
    // this file exists to prevent.
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');

    set_exception_handler(static function (Throwable $e): void {
        pf_log_failure(
            'uncaught ' . $e::class,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
        error_log($e->getTraceAsString());
        pf_render_error_page();
    });

    register_shutdown_function(static function (): void {
        $last = error_get_last();
        if ($last === null || ($last['type'] & PF_FATAL_ERRORS) === 0) {
            return;             // clean end, or a notice PHP already logged
        }
        pf_log_failure('fatal', $last['message'], $last['file'], $last['line']);
        pf_render_error_page();
    });
}
