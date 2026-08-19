<?php
/**
 * The validation gate — every check that must pass before code leaves this
 * machine.
 *
 *   php tools/validate.php            run every gate, stop at the first failure
 *   php tools/validate.php --all      run every gate even after one fails
 *
 * Exit code 0 when everything passes, 1 otherwise. This is what
 * .githooks/pre-push runs, so a push that reaches GitHub has already passed
 * all four gates. See docs/VALIDATION.md for why the gate lives here rather
 * than in a GitHub Actions workflow.
 *
 * Each gate is a closure returning [bool $passed, string $detail]. Adding a
 * fifth gate means adding one entry to $gates and nothing else.
 */

declare(strict_types=1);

$root      = dirname(__DIR__);
$continue  = in_array('--all', $argv, true);
$php       = PHP_BINARY;

/** Run a command, capture combined output, return [exitCode, output]. */
function run(string $cmd): array
{
    $output = [];
    $code   = 0;
    exec($cmd . ' 2>&1', $output, $code);
    return [$code, implode("\n", $output)];
}

/** Files git tracks, filtered to PHP, minus the release directory. */
function tracked_php_files(string $root): array
{
    [$code, $out] = run('git -C ' . escapeshellarg($root) . ' ls-files -z -- "*.php"');
    if ($code !== 0) {
        return [];
    }
    $files = array_filter(explode("\0", $out));
    return array_values(array_filter(
        $files,
        static fn(string $f): bool => !str_starts_with($f, 'release/')
    ));
}

$gates = [];

// -- 1. Syntax ---------------------------------------------------------------
// Every tracked PHP file parses. Tracked, not "every file on disk": an
// untracked scratch file with a typo is the author's business, not the
// repository's.
$gates['syntax'] = static function () use ($root, $php): array {
    $files = tracked_php_files($root);
    if ($files === []) {
        return [false, 'could not list tracked PHP files — is this a git checkout?'];
    }
    $broken = [];
    foreach ($files as $file) {
        [$code, $out] = run(
            escapeshellarg($php) . ' -l ' . escapeshellarg($root . '/' . $file)
        );
        if ($code !== 0) {
            $broken[] = trim($out);
        }
    }
    return $broken === []
        ? [true, count($files) . ' tracked PHP file(s) parse']
        : [false, implode("\n", $broken)];
};

// -- 2. QA -------------------------------------------------------------------
$gates['qa'] = static function () use ($root, $php): array {
    [$code, $out] = run(
        escapeshellarg($php) . ' ' . escapeshellarg($root . '/tools/qa.php')
    );
    // qa.php's own summary line is the useful part of a long report.
    $summary = '';
    foreach (array_reverse(explode("\n", $out)) as $line) {
        if (str_contains($line, 'failure(s)')) {
            $summary = trim($line);
            break;
        }
    }
    return $code === 0
        ? [true, $summary !== '' ? $summary : 'tools/qa.php passed']
        : [false, $out];
};

// -- 3. Release build --------------------------------------------------------
// The release builder re-runs lint and QA itself and refuses to package a
// broken tree. Running it here means "the thing we would actually upload can
// still be produced", which is a different question from "the source parses".
$gates['release'] = static function () use ($root, $php): array {
    [$code, $out] = run(
        escapeshellarg($php) . ' ' . escapeshellarg($root . '/tools/build-release.php')
    );
    return $code === 0
        ? [true, 'release zip builds']
        : [false, $out];
};

// -- 4. Sitemap freshness ----------------------------------------------------
// The committed sitemap.xml must be what the generator produces from the
// current registry. Regenerate into place, compare, and always put the
// committed file back — this gate reports, it never edits the working tree.
$gates['sitemap'] = static function () use ($root, $php): array {
    $path = $root . '/sitemap.xml';
    if (!is_file($path)) {
        return [false, 'sitemap.xml is missing from the repository root'];
    }
    $committed = file_get_contents($path);

    [$code, $out] = run(
        escapeshellarg($php) . ' ' . escapeshellarg($root . '/tools/build-sitemap.php')
    );
    if ($code !== 0) {
        file_put_contents($path, $committed);
        return [false, "tools/build-sitemap.php failed:\n" . $out];
    }

    $generated = file_get_contents($path);
    file_put_contents($path, $committed);

    return $generated === $committed
        ? [true, 'sitemap.xml matches the registry']
        : [false, "sitemap.xml is stale — run: php tools/build-sitemap.php\n"
            . 'and commit the result (' . strlen($committed) . ' bytes committed, '
            . strlen($generated) . ' bytes generated)'];
};

// -- Run ---------------------------------------------------------------------
$failed = [];
foreach ($gates as $name => $gate) {
    printf("== %s %s", $name, str_repeat('.', max(1, 14 - strlen($name))));
    [$passed, $detail] = $gate();
    if ($passed) {
        echo " ok   " . $detail . "\n";
        continue;
    }
    echo " FAIL\n";
    echo rtrim($detail) . "\n\n";
    $failed[] = $name;
    if (!$continue) {
        break;
    }
}

echo str_repeat('-', 64) . "\n";
if ($failed === []) {
    echo "validation gate: all " . count($gates) . " gates pass.\n";
    exit(0);
}
echo 'validation gate: FAILED (' . implode(', ', $failed) . ").\n";
if (!$continue) {
    echo "Stopped at the first failure; run with --all to see every gate.\n";
}
exit(1);
