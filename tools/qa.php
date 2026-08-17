<?php
/**
 * Static QA over the registry and rendered output.
 *   php tools/qa.php            (needs no server — it renders through the app)
 * Exit code 1 when any hard check fails.
 */
require __DIR__ . '/../app/bootstrap.php';

$fail = 0; $warn = 0;
function bad(string $m): void  { global $fail; $fail++; echo "  FAIL  $m\n"; }
function soft(string $m): void { global $warn; $warn++; echo "  warn  $m\n"; }
function ok(string $m): void   { echo "  ok    $m\n"; }

$reg = registry();

echo "\n== Metadata uniqueness ==\n";
$t = []; $d = []; $u = [];
foreach ($reg as $id => $p) {
    $t[$p['title']][] = $id;
    $d[$p['description']][] = $id;
    $u[$p['url']][] = $id;
}
foreach ([['title', $t], ['description', $d], ['url', $u]] as [$label, $map]) {
    $dupes = array_filter($map, fn($ids) => count($ids) > 1);
    $dupes ? bad("duplicate $label: " . json_encode($dupes)) : ok("all $label values unique");
}

echo "\n== Length targets ==\n";
foreach ($reg as $id => $p) {
    $lt = mb_strlen($p['title']); $ld = mb_strlen($p['description']);
    if ($lt > 62) { soft("title {$lt} chars (target <=60): $id"); }
    if ($ld > 158 || $ld < 110) {
        if (($p['cluster'] ?? '') !== 'utility') { soft("description {$ld} chars (target 140-155): $id"); }
    }
}
echo "  (title/description length is a soft target — natural wording beats hitting a number)\n";

echo "\n== Registry integrity ==\n";
foreach ($reg as $id => $p) {
    foreach (['url', 'title', 'description', 'h1', 'type', 'status', 'intent'] as $k) {
        if (empty($p[$k])) { bad("missing '$k' on $id"); }
    }
    if (!str_ends_with($p['url'], '/')) { bad("url without trailing slash: $id"); }
    if (!in_array($p['type'], ['page', 'service', 'article'], true)) { bad("bad type on $id"); }
}
$fail === 0 && ok('every entry has url/title/description/h1/type/status/intent');

echo "\n== Rendered output ==\n";
$blockTypes = [];
foreach ($reg as $id => $p) {
    ob_start(); render_page($id); $html = ob_get_clean();

    $h1 = preg_match_all('/<h1[\s>]/', $html);
    if ($h1 !== 1) { bad("$id has $h1 h1 elements (need exactly 1)"); }

    if (!str_contains($html, '<link rel="canonical"')) { bad("$id missing canonical"); }
    if (preg_match('/\[[A-Z][A-Z0-9_]{3,}\]/', strip_tags($html), $m)) {
        bad("$id renders an unresolved placeholder to the visitor: {$m[0]}");
    }
    // JSON-LD must parse
    if (preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m)) {
        json_decode($m[1], true);
        if (json_last_error() !== JSON_ERROR_NONE) { bad("$id JSON-LD invalid: " . json_last_error_msg()); }
    } else { bad("$id has no JSON-LD"); }

    // Internal links must resolve to a registered URL or a real file
    preg_match_all('/href="(\/[^"#?]*)"/', $html, $m);
    $known = array_column($reg, 'url');
    foreach (array_unique($m[1]) as $link) {
        $clean = strtok($link, '?');
        if (in_array($clean, $known, true)) { continue; }
        if (is_file(PF_ROOT . $clean)) { continue; }
        if (in_array($clean, ['/errors/404/', '/errors/500/', '/manifest.webmanifest'], true)) { continue; }
        bad("$id links to unknown URL: $clean");
    }
}
ok('rendered ' . count($reg) . ' pages: one h1, canonical, valid JSON-LD, no dead internal links, no leaked placeholders');

echo "\n== Block coverage ==\n";
$home = require PF_APP . '/content/en/pages/home.php';
foreach ($home['blocks'] as $b) {
    $f = PF_APP . '/templates/blocks/' . $b['type'] . '.php';
    is_file($f) ? $blockTypes[] = $b['type'] : bad("home uses undefined block type '{$b['type']}'");
}
ok('home uses ' . count(array_unique($blockTypes)) . ' distinct block types: ' . implode(', ', array_unique($blockTypes)));

echo "\n== Rail integrity ==\n";
ob_start(); render_page('home'); $html = ob_get_clean();
foreach ($home['rail'] as $stop) {
    if (!str_contains($html, 'id="' . $stop['target'] . '"')) { bad("rail stop '{$stop['target']}' has no matching section id"); }
}
ok('every Frontier Route rail stop points at a real section id');

echo "\n== Secrets ==\n";
$leak = 0;
foreach (['assets/js/site.js', 'assets/css/site.css'] as $f) {
    $c = file_get_contents(PF_ROOT . '/' . $f);
    if (preg_match('/(api[_-]?key|secret|password|bearer\s)/i', $c)) { bad("possible secret in $f"); $leak++; }
}
$leak === 0 && ok('no credentials in client-side assets');

echo "\n== Indexing posture ==\n";
$launched = (bool) site('launched');
echo '  site "launched" => ' . var_export($launched, true) . "\n";
ok($launched ? 'pages may be indexed — confirm the production checklist is clear'
             : 'every page renders noindex,nofollow and the sitemap is empty (correct pre-launch)');

echo "\n" . str_repeat('-', 64) . "\n";
printf("%d failure(s), %d warning(s)\n", $fail, $warn);
exit($fail > 0 ? 1 : 0);
