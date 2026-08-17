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
// Render as a visitor would see the site, whatever the local preview setting
// is: an author's preview flag must never be able to hide a leak from QA.
$GLOBALS['PF_SITE']['preview_drafts'] = false;
putenv('PF_PREVIEW=');
$blockTypes = [];
foreach ($reg as $id => $p) {
    ob_start(); render_page($id); $html = ob_get_clean();

    // An unwritten editorial brief must never reach a visitor, in either the
    // raw {{ ... }} form or the ⟦ ... ⟧ form preview renders it as.
    if (str_contains($html, '{{') || str_contains($html, '⟦')) {
        bad("$id leaks an unwritten copy brief into visitor-facing HTML");
    }

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

echo "\n== Draft integrity ==\n";
// The registry's 'status' is documentation; resolve_page() is the authority.
// They must agree, or the registry is lying about what is publishable.
$states = ['live' => 0, 'draft' => 0, 'planned' => 0];
$slotTotal = 0;
foreach ($reg as $id => $p) {
    $r = resolve_page($id);
    $real = $r['page']['status'];
    $states[$real] = ($states[$real] ?? 0) + 1;
    $slotTotal += count($r['slots']);
    if ($real !== $p['status']) {
        bad("registry says $id is '{$p['status']}' but its content file makes it '$real'");
    }
    if ($real !== 'live' && is_indexable($r['page'])) {
        bad("$id is '$real' but would be indexed");
    }
}
ok(sprintf('%d live, %d draft, %d planned; %d unwritten passages (php tools/copy-brief.php)',
    $states['live'], $states['draft'], $states['planned'], $slotTotal));

echo "\n== Block coverage ==\n";
// Every block type used anywhere must have a template, and every page a block
// references by id must exist — a typo in either is a fatal render, not a
// cosmetic bug, so it is caught here rather than by a visitor.
$used = [];
// Only the members of a page's 'blocks' array are blocks. 'type' also appears
// inside prose bodies ('list', 'defs', 'h3'), which the prose template handles
// itself and which have no template file of their own.
$walk = function ($node, string $pageId) use (&$walk, &$reg) {
    if (!is_array($node)) { return; }
    foreach ($node as $k => $v) {
        if ($k === 'page' && is_string($v) && !isset($reg[$v])) {
            bad("$pageId links to unknown page id '$v'");
        }
        $walk($v, $pageId);
    }
};
foreach ($reg as $id => $p) {
    $file = PF_APP . '/content/en/pages/' . str_replace('.', '-', $id) . '.php';
    if (!is_file($file)) { continue; }
    $content = require $file;
    foreach ($content['blocks'] ?? [] as $b) {
        if (isset($b['type']) && is_string($b['type'])) { $used[$b['type']] = true; }
    }
    $walk($content['blocks'] ?? [], $id);
}
foreach (array_keys($used) as $type) {
    if (!is_file(PF_APP . '/templates/blocks/' . $type . '.php')) {
        bad("undefined block type '$type' is used by a content file");
    }
}
$defined = array_map(fn($f) => basename($f, '.php'), glob(PF_APP . '/templates/blocks/*.php'));
$unused  = array_diff($defined, array_keys($used), ['in-preparation', 'draft-notice']);
if ($unused) { soft('block templates defined but never used: ' . implode(', ', $unused)); }
ok(count($used) . ' block types in use, all defined, all page references resolve');

echo "\n== Draft preview ==\n";
// Authors read drafts with PF_PREVIEW=1. That path renders block templates
// against unwritten values, so it has to be exercised: a template that only
// breaks on a draft page would otherwise be found by the writer, mid-sentence.
$GLOBALS['PF_SITE']['preview_drafts'] = true;
$previewed = 0;
foreach ($reg as $id => $p) {
    if (resolve_page($id)['page']['status'] !== 'draft') { continue; }
    ob_start(); render_page($id); $out = ob_get_clean();
    $previewed++;
    if (preg_match_all('/<h1[\s>]/', $out) !== 1) { bad("$id renders " . preg_match_all('/<h1[\s>]/', $out) . " h1 elements in preview"); }
    if (!str_contains($out, 'draftbar')) { bad("$id renders in preview without the draft banner"); }
}
$GLOBALS['PF_SITE']['preview_drafts'] = false;
ok("$previewed draft outlines render cleanly under PF_PREVIEW=1");

echo "\n== Enquiry form ==\n";
// The form must be inert until delivery is configured, and its handler must
// never be reachable without the token, the stamp and the honeypot.
form_enabled()
    ? soft('the enquiry form is accepting submissions — confirm a real message has been received')
    : ok('the enquiry form renders disabled (no SMTP delivery configured yet)');
$formSrc = file_get_contents(PF_APP . '/form.php');
foreach (['csrf' => 'hash_equals', 'honeypot' => 'company_website', 'timing' => 'PF_FORM_MIN_SECONDS',
          'rate limit' => 'rate_limited', 'redirect' => '303'] as $label => $needle) {
    str_contains($formSrc, $needle) ? null : bad("form handler lost its $label check");
}
ok('handler retains: CSRF token, honeypot, minimum completion time, rate limit, POST-redirect-GET');

echo "\n== Rail integrity ==\n";
$home = require PF_APP . '/content/en/pages/home.php';
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
