<?php
/**
 * Builds the upload-ready Hostinger release.
 *   php tools/build-release.php
 *
 * Produces release/paraguayfrontier-mvp-hostinger.zip whose ROOT is the document
 * root — no extra nesting directory. Extracting it into public_html gives you a
 * working site.
 *
 * Archive entries always use forward slashes. ZipArchive::addFile writes the
 * name it is given verbatim, so the path is normalised explicitly rather than
 * trusted, which is what stops "assets\css\site.css" entries appearing on a
 * Windows toolchain.
 */
declare(strict_types=1);

$root    = dirname(__DIR__);
$outDir  = $root . '/release';
$outFile = $outDir . '/paraguayfrontier-mvp-hostinger.zip';

/**
 * Excluded from the release:
 *  .git       — history has no business on a web host
 *  release    — no recursive packaging
 *  docs       — internal working notes; .htaccess blocks them, but a host that
 *               ignores .htaccess would expose the production-data checklist
 *  config/site.php, config/env.php — server-owned. They must survive a
 *               redeploy, so the release never carries them. Only the .example
 *               files ship; app/bootstrap.php falls back to the example when
 *               site.php is absent, so the site runs before you configure it.
 */
$excludeDirs  = ['.git', 'release', 'docs'];
$excludeFiles = ['config/site.php', 'config/env.php', '.gitignore'];

@mkdir($outDir, 0755, true);
@unlink($outFile);

$zip = new ZipArchive();
if ($zip->open($outFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Could not create {$outFile}\n");
    exit(1);
}

$it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

$count = 0;
$bytes = 0;
foreach ($it as $path) {
    $rel = str_replace('\\', '/', substr((string) $path, strlen($root) + 1));

    $top = explode('/', $rel)[0];
    if (in_array($top, $excludeDirs, true)) {
        continue;
    }
    if (in_array($rel, $excludeFiles, true)) {
        continue;
    }
    if (is_dir((string) $path)) {
        $zip->addEmptyDir($rel);
        continue;
    }
    $zip->addFile((string) $path, $rel);
    $count++;
    $bytes += (int) filesize((string) $path);
}

$zip->close();

printf("%s\n  %d files, %.1f KB uncompressed, %.1f KB archived\n",
    $outFile, $count, $bytes / 1024, filesize($outFile) / 1024);

// --- Verify what we just wrote ------------------------------------------------
$check = new ZipArchive();
$check->open($outFile);
$names = [];
for ($i = 0; $i < $check->numFiles; $i++) {
    $names[] = $check->getNameIndex($i);
}
$check->close();

$problems = [];
foreach ($names as $n) {
    if (str_contains($n, '\\')) {
        $problems[] = "backslash in entry: {$n}";
    }
}
foreach (['index.php', '.htaccess', 'robots.txt', 'sitemap.xml', 'manifest.webmanifest'] as $required) {
    if (!in_array($required, $names, true)) {
        $problems[] = "missing at archive root: {$required}";
    }
}
foreach (['assets/css/site.css', 'assets/js/site.js', 'app/bootstrap.php',
          'config/site.example.php', 'guides/residency/index.php',
          'services/residency/index.php', 'errors/404/index.php'] as $required) {
    if (!in_array($required, $names, true)) {
        $problems[] = "missing: {$required}";
    }
}
foreach ($names as $n) {
    if (str_starts_with($n, 'docs/') || $n === 'config/site.php' || $n === 'config/env.php') {
        $problems[] = "should not be in the release: {$n}";
    }
}

if ($problems) {
    echo "\nARCHIVE PROBLEMS:\n";
    foreach ($problems as $p) {
        echo "  - {$p}\n";
    }
    exit(1);
}
echo "  verified: forward slashes only, document root at archive root, no docs or server config included\n";
