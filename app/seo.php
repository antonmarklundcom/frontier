<?php
declare(strict_types=1);

/**
 * Indexing policy, resolved in one place.
 *
 * The site is noindex until config 'launched' is true. Individual pages can
 * opt out with 'index' => false, and any page still marked 'planned' is never
 * indexable regardless of configuration. This is deliberately conservative:
 * shipping a half-written residency guide into the index is far more expensive
 * than shipping it late.
 */
function robots_directive(array $page): string
{
    $launched = (bool) site('launched');
    $pageAllows = ($page['index'] ?? true) && ($page['status'] ?? 'planned') === 'live';
    return ($launched && $pageAllows) ? 'index,follow,max-image-preview:large' : 'noindex,nofollow';
}

/** True when the page belongs in sitemap.xml. */
function is_indexable(array $page): bool
{
    return robots_directive($page) !== 'noindex,nofollow';
}

/** Open Graph image URL for a page, falling back to the site default. */
function og_image(array $page): string
{
    return url($page['og_image'] ?? (string) site('og_default'));
}

/**
 * Breadcrumb trail, derived from the URL path against the registry so it can
 * never drift out of sync with the navigation.
 */
function breadcrumbs(array $page, array $registry): array
{
    $trail = [['label' => 'Home', 'url' => '/']];
    if ($page['url'] === '/') {
        return $trail;
    }
    $byUrl = [];
    foreach ($registry as $entry) {
        $byUrl[$entry['url']] = $entry;
    }
    $parts = array_values(array_filter(explode('/', trim($page['url'], '/'))));
    $path = '';
    foreach ($parts as $part) {
        $path .= '/' . $part;
        $candidate = $path . '/';
        if (!isset($byUrl[$candidate])) {
            continue; // e.g. /guides/ is a grouping segment, not a page
        }
        $trail[] = [
            'label' => $byUrl[$candidate]['breadcrumb'] ?? $byUrl[$candidate]['h1'],
            'url'   => $candidate,
        ];
    }
    return $trail;
}
