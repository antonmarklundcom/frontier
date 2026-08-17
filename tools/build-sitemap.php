<?php
/**
 * Regenerates sitemap.xml from the registry. Only indexable pages are listed —
 * a page that is noindex must never appear in a sitemap.
 *   php tools/build-sitemap.php
 */
require __DIR__ . '/../app/bootstrap.php';

$urls = [];
foreach (registry() as $id => $entry) {
    $page = $entry + ['id' => $id];
    $file = PF_APP . '/content/en/pages/' . str_replace('.', '-', $id) . '.php';
    if (!is_file($file)) {
        $page['status'] = 'planned';
    }
    if (!is_indexable($page)) {
        continue;
    }
    $urls[] = $page;
}

$xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($urls as $p) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars(url($p['url']), ENT_XML1) . "</loc>\n";
    if (!empty($p['last_reviewed'])) {
        $xml .= "    <lastmod>" . $p['last_reviewed'] . "</lastmod>\n";
    }
    $xml .= "  </url>\n";
}
$xml .= "</urlset>\n";

file_put_contents(PF_ROOT . '/sitemap.xml', $xml);
printf("sitemap.xml written: %d indexable URL(s) of %d registered.\n", count($urls), count(registry()));
if (count($urls) === 0) {
    echo "NOTE: the site is configured as pre-launch ('launched' => false), so nothing is indexable yet.\n";
    echo "      The empty sitemap is correct until docs/PRODUCTION-DATA-REQUIRED.md is cleared.\n";
}
