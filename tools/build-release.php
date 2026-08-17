<?php
/**
 * Builds the Hostinger release zip.
 *   php tools/build-release.php            (aborts if lint or QA fails)
 *   php tools/build-release.php --force    (builds anyway — staging only)
 *
 * The zip's root IS the document root: extracting it into public_html puts
 * index.php at public_html/index.php, with no extra nesting level.
 *
 * What is deliberately left out:
 *   .git/        version control
 *   docs/        internal planning notes — no reason to sit on a web server
 *   tools/       build scripts — same
 *   release/     previous builds
 *   config/site.php, config/env.php   local values and secrets; the server's
 *                copies are authoritative and are never overwritten by a deploy
 * The two .example.php files DO ship: bootstrap.php falls back to
 * site.example.php, so a first upload renders rather than fatals.
 */

declare(strict_types=1);

$force = in_array('--force', $argv, true);
$root  = dirname(__DIR__);

// ---------------------------------------------------------------- pre-flight
echo "== Syntax ==\n";
$lintErrors = [];
$phpFiles   = [];
$it = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        function ($file) {
            $name = $file->getFilename();
            return !in_array($name, ['.git', 'release'], true);
        }
    )
);
foreach ($it as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $phpFiles[] = $file->getPathname();
    }
}
sort($phpFiles);
foreach ($phpFiles as $f) {
    exec('php -l ' . escapeshellarg($f) . ' 2>&1', $out, $code);
    if ($code !== 0) { $lintErrors[] = $f . ': ' . implode(' ', $out); }
    $out = [];
}
if ($lintErrors) {
    foreach ($lintErrors as $e) { echo "  FAIL  $e\n"; }
} else {
    printf("  ok    %d PHP files parse\n", count($phpFiles));
}

echo "\n== QA ==\n";
exec('php ' . escapeshellarg($root . '/tools/qa.php') . ' 2>&1', $qaOut, $qaCode);
foreach ($qaOut as $line) {
    if (str_contains($line, 'FAIL') || preg_match('/failure\(s\)/', $line)) { echo "  $line\n"; }
}
echo $qaCode === 0 ? "  ok    QA passed\n" : "  FAIL  QA exited $qaCode\n";

if (($lintErrors || $qaCode !== 0) && !$force) {
    echo "\nRelease NOT built. Fix the failures above, or pass --force for a staging build.\n";
    exit(1);
}
if (($lintErrors || $qaCode !== 0) && $force) {
    echo "\n  !!    building anyway (--force). Do not put this build on the live domain.\n";
}

// ------------------------------------------------------------------ contents
$skipTop  = ['.git', '.gitignore', 'docs', 'tools', 'release'];
$skipFile = ['config/site.php', 'config/env.php', '.DS_Store'];

$files = [];
$walk = function (string $dir, string $prefix = '') use (&$walk, &$files, $root, $skipTop, $skipFile) {
    foreach (scandir($dir) as $entry) {
        if ($entry === '.' || $entry === '..') { continue; }
        $abs = $dir . '/' . $entry;
        $rel = $prefix === '' ? $entry : $prefix . '/' . $entry;
        if ($prefix === '' && in_array($entry, $skipTop, true)) { continue; }
        if (in_array($rel, $skipFile, true) || $entry === '.DS_Store') { continue; }
        if (str_ends_with($entry, '.log')) { continue; }
        is_dir($abs) ? $walk($abs, $rel) : $files[] = $rel;
    }
};
$walk($root);
sort($files);

// -------------------------------------------------------------------- the zip
$releaseDir = $root . '/release';
if (!is_dir($releaseDir)) { mkdir($releaseDir, 0775, true); }
$stamp = date('Y-m-d-Hi');
$zipPath = $releaseDir . "/paraguayfrontier-{$stamp}.zip";

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Could not create $zipPath\n");
    exit(1);
}
$bytes = 0;
foreach ($files as $rel) {
    $zip->addFile($root . '/' . $rel, $rel);
    $bytes += filesize($root . '/' . $rel);
}
$zip->close();

echo "\n== Release ==\n";
printf("  %s\n", $zipPath);
printf("  %d files, %s uncompressed, %s zipped\n",
    count($files),
    number_format($bytes / 1024, 0) . ' KB',
    number_format(filesize($zipPath) / 1024, 0) . ' KB');
echo "  zip root = document root: unzip into public_html, no nested folder\n";

// -------------------------------------------------------- post-build reminder
require $root . '/app/bootstrap.php';
$site = $GLOBALS['PF_SITE'];
$open = [];
foreach ($site as $k => $v) {
    if (is_string($v) && is_placeholder($v)) { $open[] = $k; }
}

echo "\n== State of this build ==\n";
printf("  config source   : %s\n", is_file($root . '/config/site.php') ? 'config/site.php' : 'config/site.example.php (no local site.php)');
printf("  launched flag   : %s\n", !empty($site['launched']) ? 'true — indexable' : 'false — noindex,nofollow site-wide');
printf("  robots.txt      : %s\n", str_contains(file_get_contents($root . '/robots.txt'), "\nDisallow: /") ? 'Disallow: / (closed to crawlers)' : 'open to crawlers');
if ($open) {
    printf("  unresolved      : %s\n", implode(', ', $open));
    echo "  Contact surfaces tied to those values are suppressed, not rendered.\n";
    echo "  See docs/PRODUCTION-DATA-REQUIRED.md.\n";
} else {
    echo "  unresolved      : none\n";
}
echo "\nNext: docs/HOSTINGER-DEPLOYMENT.md\n";
