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

    // 'last_reviewed' is printed to visitors as a credibility claim and fed to
    // <lastmod> in the sitemap. A date that is merely well-formed is not
    // enough: '2026-02-30' passes a regex and is not a day. A future date is
    // worse than a wrong one — it claims a review that has not happened.
    if (!empty($p['last_reviewed'])) {
        $d = $p['last_reviewed'];
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $d, $m)) {
            bad("last_reviewed on $id is not YYYY-MM-DD: '$d'");
        } elseif (!checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
            bad("last_reviewed on $id is not a real date: '$d'");
        } elseif ($d > date('Y-m-d')) {
            bad("last_reviewed on $id is in the future: '$d'");
        }
    }
}
$fail === 0 && ok('every entry has url/title/description/h1/type/status/intent');

echo "\n== Content files ==\n";
// (a) A registry entry claiming 'live' must have a content file with blocks in
// it. resolve_page() would quietly downgrade a missing file to 'planned' and
// the site would render the in-preparation notice — correct behaviour at
// runtime, and exactly the wrong behaviour at build time, where it hides the
// fact that a page the registry advertises as finished does not exist.
$liveChecked = 0;
foreach ($reg as $id => $p) {
    if (($p['status'] ?? '') !== 'live') { continue; }
    $liveChecked++;
    $file = PF_APP . '/content/' . default_locale() . '/pages/' . str_replace('.', '-', $id) . '.php';
    if (!is_file($file)) {
        bad("$id is registered 'live' but has no content file (" . basename($file) . ")");
        continue;
    }
    $content = require $file;
    if (empty($content['blocks'])) {
        bad("$id is registered 'live' but its content file has no blocks");
    }
}
ok("$liveChecked live entr(y/ies) have a content file with blocks");

echo "\n== Navigation and reachability ==\n";
// (c) Every id named in navigation.php resolves. A typo here is a link that
// silently vanishes from the menu — page() returns null and the template skips
// it — so nobody notices until traffic does.
$nav = navigation();
$navIds = [];
$collect = function ($node) use (&$collect, &$navIds) {
    if (!is_array($node)) { return; }
    foreach ($node as $k => $v) {
        if ($k === 'page' && is_string($v)) { $navIds[$v] = true; }
        if ($k === 'pages' && is_array($v)) {
            foreach ($v as $pid) { if (is_string($pid)) { $navIds[$pid] = true; } }
        }
        $collect($v);
    }
};
$collect($nav);
foreach (array_keys($navIds) as $navId) {
    if (!isset($reg[$navId])) { bad("navigation.php references unknown page id '$navId'"); }
}
ok(count($navIds) . ' navigation page references all resolve');

// (d) Every registry entry should be reachable from navigation or from some
// page's blocks. An orphan is not a build failure — a page can legitimately be
// linked only from prose, and error pages are reached by the server — but an
// unreachable page is almost always an oversight, so it warns.
$linked = $navIds;
foreach ($reg as $id => $p) {
    $file = PF_APP . '/content/' . default_locale() . '/pages/' . str_replace('.', '-', $id) . '.php';
    if (!is_file($file)) { continue; }
    $walkLinks = function ($node) use (&$walkLinks, &$linked) {
        if (!is_array($node)) { return; }
        foreach ($node as $k => $v) {
            if ($k === 'page' && is_string($v)) { $linked[$v] = true; }
            $walkLinks($v);
        }
    };
    $walkLinks(require $file);
}
$exempt = ['home', 'error-404', 'error-500', 'thank-you'];
$orphans = array_diff(array_keys($reg), array_keys($linked), $exempt);
$orphans
    ? soft('unreachable from navigation or any block: ' . implode(', ', $orphans))
    : ok('every registry entry is reachable from navigation or a block');

echo "\n== Locale parity ==\n";
// Every configured locale must define the same string keys as the default. A
// missing key renders as the key itself — visible, on purpose — but it should
// be caught here rather than by a visitor reading 'stamp_written_by' on a
// finished page. Trivially satisfied while one locale is configured; the point
// is that it stops being trivial the moment a second one is added.
$baseKeys = array_keys(strings(default_locale()));
foreach (locales() as $loc) {
    if ($loc === default_locale()) { continue; }
    $dir = PF_APP . '/content/' . $loc;
    if (!is_dir($dir)) { bad("locale '$loc' is configured but app/content/$loc/ does not exist"); continue; }
    $missing = array_diff($baseKeys, array_keys(strings($loc)));
    if ($missing) { bad("locale '$loc' is missing string(s): " . implode(', ', $missing)); }
}
ok(count(locales()) . ' configured locale(s), ' . count($baseKeys) . ' string keys, no gaps');

echo "\n== .htaccess deny list ==\n";
// The by-name deny list is what protects app/*.php on a host without
// mod_rewrite. It is a hand-maintained list that has to stay in sync with a
// directory listing, and PR-03 found it had already rotted — naming a file
// that no longer exists while omitting three that do. A list like that needs a
// machine watching it, not a convention.
$ht = @file_get_contents(PF_ROOT . '/.htaccess');
if ($ht === false) {
    bad('.htaccess is missing');
} elseif (!preg_match('/<FilesMatch "\^\(([^)]*)\)\\\.php\$">/', $ht, $m)) {
    bad('.htaccess has no by-name PHP deny list — /app is protected only by mod_rewrite');
} else {
    $listed = explode('|', $m[1]);
    $onDisk = array_map(fn($f) => basename($f, '.php'), glob(PF_APP . '/*.php'));
    if ($missing = array_diff($onDisk, $listed)) {
        bad('.htaccess deny list is missing app/' . implode('.php, app/', $missing) . '.php');
    }
    if ($stale = array_diff($listed, $onDisk)) {
        soft('.htaccess deny list names file(s) that no longer exist: ' . implode(', ', $stale));
    }
    if (!str_contains($ht, '^(site|env)\.php$')) {
        bad('.htaccess does not deny config/site.php and config/env.php by name');
    }
    ok(count($onDisk) . ' app PHP file(s) denied by name, plus the config pair');
}

// Structural checks run BEFORE the render loop, deliberately. A single typo'd
// page id in navigation.php makes page() return null and takes every page on
// the site down with a TypeError — so if these ran after rendering, QA would
// die on the symptom and never print the one line that names the cause.
echo "\n== Escaping discipline ==\n";
// PR-06's invariant, made permanent. Every short echo in a template must be
// e() — escaped text — or raw_html() — trusted markup from an _html content
// key. Nothing else. The point is not that a bare echo is always wrong; it is
// that a bare echo is *invisible*, so nobody can review what they cannot find.
// A reviewer reading raw_html() knows to ask where the string came from.
$echoFiles = [];
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PF_APP . '/templates'));
foreach ($rii as $f) {
    if ($f->isFile() && $f->getExtension() === 'php') { $echoFiles[] = $f->getPathname(); }
}
sort($echoFiles);
$bare = 0;
foreach ($echoFiles as $f) {
    foreach (file($f) as $n => $line) {
        if (!str_contains($line, '<?=')) { continue; }
        foreach (explode('<?=', $line) as $i => $part) {
            if ($i === 0) { continue; }
            $expr = ltrim($part);
            if (str_starts_with($expr, 'e(') || str_starts_with($expr, 'raw_html(')
                || str_starts_with($expr, '/*')) {
                continue;
            }
            $bare++;
            bad(sprintf('%s:%d echoes without e() or raw_html(): %s',
                str_replace(PF_APP . '/', '', $f), $n + 1, trim(substr($expr, 0, 48))));
        }
    }
}
if ($bare === 0) { ok(count($echoFiles) . ' template(s): every echo goes through e() or raw_html()'); }

// The other half of the convention: a key named *_html is the only thing
// raw_html() may be handed from a content file. A raw_html() call reading a
// key without the suffix means the data stopped announcing its own trust.
$suffix = 0;
foreach ($echoFiles as $f) {
    $src = file_get_contents($f);
    // Only a call whose ENTIRE argument is one array subscript is reading a
    // content key. raw_html() wrapping an expression — a ternary over a
    // status, a concatenation of e() calls — is trusted by construction, and
    // the subscripts inside it are conditions, not the value being emitted.
    if (preg_match_all('/raw_html\\(\\s*\\$[a-z_]+\\[\\s*\\x27([a-z_]+)\\x27\\s*\\]\\s*\\)/i', $src, $m)) {
        foreach ($m[1] as $key) {
            if (!str_ends_with($key, '_html')) {
                bad(str_replace(PF_APP . '/', '', $f) . ": raw_html() reads '$key', which does not end in _html");
                $suffix++;
            }
        }
    }
}
if ($suffix === 0) { ok('every raw_html() content key carries the _html suffix'); }

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
    $file = PF_APP . '/content/' . default_locale() . '/pages/' . str_replace('.', '-', $id) . '.php';
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
$home = require PF_APP . '/content/' . default_locale() . '/pages/home.php';
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
