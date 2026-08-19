<?php
/**
 * Points this checkout's git hooks at the versioned .githooks directory.
 *
 *   php tools/install-hooks.php
 *
 * Hooks are per-checkout, not per-repository: git deliberately refuses to
 * ship executable code to anyone who clones. So every fresh clone — and every
 * ephemeral build container — has to run this once. It is idempotent.
 *
 * core.hooksPath is used rather than copying files into .git/hooks so that
 * the hook stays under version control: editing .githooks/pre-push changes
 * the gate for everyone, with review, instead of drifting per machine.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$hook = $root . '/.githooks/pre-push';

if (!is_file($hook)) {
    fwrite(STDERR, "install-hooks: .githooks/pre-push is missing.\n");
    exit(1);
}

$check = [];
$code  = 0;
exec('git -C ' . escapeshellarg($root) . ' rev-parse --git-dir 2>&1', $check, $code);
if ($code !== 0) {
    fwrite(STDERR, "install-hooks: not a git checkout — nothing to install.\n");
    exit(1);
}

// Not every filesystem carries the executable bit (Windows checkouts, some
// container mounts). chmod is best-effort; git runs hooks via the shell
// regardless of mode on those platforms.
@chmod($hook, 0o755);

$out = [];
exec(
    'git -C ' . escapeshellarg($root) . ' config core.hooksPath .githooks 2>&1',
    $out,
    $code
);
if ($code !== 0) {
    fwrite(STDERR, "install-hooks: could not set core.hooksPath:\n" . implode("\n", $out) . "\n");
    exit(1);
}

echo "install-hooks: core.hooksPath -> .githooks\n";
echo "               pre-push will now run php tools/validate.php.\n";
echo "               Undo with: git config --unset core.hooksPath\n";
exit(0);
