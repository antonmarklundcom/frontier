<?php
declare(strict_types=1);

/**
 * The three content indexes, one per locale.
 *
 * Each is loaded once per locale per request. The caches are keyed by locale
 * rather than being single-valued, because tools/qa.php and the sitemap
 * builder legitimately read more than one locale in a single process.
 *
 * $locale defaults to the current request's locale, so the ~200 existing call
 * sites that never pass one keep working unchanged.
 */
function registry(?string $locale = null): array
{
    static $cache = [];
    $locale = $locale ?? locale();
    return $cache[$locale] ??= require PF_APP . '/content/' . $locale . '/registry.php';
}

function navigation(?string $locale = null): array
{
    static $cache = [];
    $locale = $locale ?? locale();
    return $cache[$locale] ??= require PF_APP . '/content/' . $locale . '/navigation.php';
}

function strings(?string $locale = null): array
{
    static $cache = [];
    $locale = $locale ?? locale();
    return $cache[$locale] ??= require PF_APP . '/content/' . $locale . '/global.php';
}

/**
 * A locale-wide string. Returning the key itself when it is missing is
 * deliberate: a missing string shows up as an obvious token in the page rather
 * than as a blank space nobody notices, and tools/qa.php can grep for it.
 */
function t(string $key, ?string $locale = null): string
{
    return strings($locale)[$key] ?? $key;
}

/**
 * A string with values interpolated, e.g. a greeting carrying a page name.
 * Translators get one sentence with a placeholder rather than a sentence
 * assembled from fragments in a template, which is the difference between a
 * translatable string and an untranslatable one.
 */
function t_format(string $key, string ...$values): string
{
    return vsprintf(t($key), $values);
}

/** Registry entry for a page id, with its id folded in. */
function page(string $id, ?string $locale = null): ?array
{
    $r = registry($locale);
    if (!isset($r[$id])) {
        return null;
    }
    return $r[$id] + ['id' => $id];
}

/**
 * URL for a page id — the only way templates should build internal links.
 *
 * Locale is carried by the registry entry, not bolted on here: each locale has
 * its own registry with its own 'url' values, so a Spanish page's URL is
 * already '/es/guias/...' when it is read. That is what makes localised slugs
 * possible instead of a translated site living under translated-in-place
 * paths, and it is why href() needs no locale parameter — by the time a URL
 * reaches it, the locale is already in the string.
 */
function page_url(string $id, ?string $locale = null): string
{
    $p = page($id, $locale);
    return $p ? $p['url'] : '/';
}

function page_title(string $id, ?string $locale = null): string
{
    $p = page($id, $locale);
    return $p['h1'] ?? $id;
}

/**
 * Render a full page. Called by every public entrypoint.
 */
function render_page(string $id, string $locale = 'en', int $httpStatus = 200): void
{
    // The one place the request's locale is decided. Everything downstream
    // reads locale() rather than being passed it.
    $locale = set_locale($locale);

    $resolved = resolve_page($id, $locale);
    if ($resolved === null) {
        http_response_code(500);
        echo 'Unknown page id: ' . e($id);
        return;
    }
    ['page' => $page, 'slots' => $slots] = $resolved;

    // A page is only "live" if it genuinely has content blocks...
    if ($page['status'] === 'planned') {
        $page['blocks'] = [['type' => 'in-preparation']];
        $page['faqs'] = [];
    } elseif ($page['status'] === 'draft') {
        // ...and no unwritten copy slots. A draft holds its finished structure
        // but not its prose: an author can see it in preview mode, a visitor
        // gets the same honest notice as a route that was never started.
        if (preview_mode()) {
            $page = mark_slots($page);
            $page['draft_slots'] = count($slots);
            array_unshift($page['blocks'], ['type' => 'draft-notice']);
        } else {
            $page['blocks'] = [['type' => 'in-preparation']];
            $page['faqs'] = [];
        }
    }

    $crumbs = breadcrumbs($page, registry($locale));

    if ($httpStatus !== 200 && !headers_sent()) {
        http_response_code($httpStatus);
    }
    if (!headers_sent()) {   // tools/qa.php renders pages into a buffer from the CLI
        header('Content-Type: text/html; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }

    partial('layout', ['page' => $page, 'crumbs' => $crumbs]);
}

/**
 * Render one content block. Unknown block types are skipped silently in
 * production and reported by tools/qa.php, so a typo can never emit raw
 * placeholder text to a visitor.
 */
function render_block(array $block, array $page): void
{
    $type = $block['type'] ?? '';
    $file = PF_APP . '/templates/blocks/' . $type . '.php';
    if ($type === '' || !is_file($file)) {
        return;
    }
    $b = $block;
    require $file;
}
