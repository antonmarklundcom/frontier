<?php
declare(strict_types=1);

/** Load the registry once per request. */
function registry(): array
{
    static $r = null;
    if ($r === null) {
        $r = require PF_APP . '/content/en/registry.php';
    }
    return $r;
}

function navigation(): array
{
    static $n = null;
    if ($n === null) {
        $n = require PF_APP . '/content/en/navigation.php';
    }
    return $n;
}

function strings(): array
{
    static $s = null;
    if ($s === null) {
        $s = require PF_APP . '/content/en/global.php';
    }
    return $s;
}

function t(string $key): string
{
    return strings()[$key] ?? $key;
}

/** Registry entry for a page id, with its id folded in. */
function page(string $id): ?array
{
    $r = registry();
    if (!isset($r[$id])) {
        return null;
    }
    return $r[$id] + ['id' => $id];
}

/** href for a page id — the only way templates should build internal links. */
function page_url(string $id): string
{
    $p = page($id);
    return $p ? $p['url'] : '/';
}

function page_title(string $id): string
{
    $p = page($id);
    return $p['h1'] ?? $id;
}

/**
 * Render a full page. Called by every public entrypoint.
 */
function render_page(string $id, int $httpStatus = 200): void
{
    $meta = page($id);
    if ($meta === null) {
        http_response_code(500);
        echo 'Unknown page id: ' . e($id);
        return;
    }

    // Merge the content file, when the page has one.
    $contentFile = PF_APP . '/content/en/pages/' . str_replace('.', '-', $id) . '.php';
    $content = is_file($contentFile) ? require $contentFile : [];
    $page = array_merge($meta, $content);

    // A page is only "live" if it genuinely has content blocks.
    if (empty($page['blocks'])) {
        $page['status'] = 'planned';
        $page['blocks'] = [['type' => 'in-preparation']];
    }

    $crumbs = breadcrumbs($page, registry());

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
