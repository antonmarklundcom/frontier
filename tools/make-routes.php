<?php
/**
 * Generates one two-line index.php per registry URL.
 * Run after adding a page to the registry:  php tools/make-routes.php
 *
 * A registry entry may name a 'post_handler'. That function is called before
 * anything is rendered, so it can validate a submission and redirect — the
 * consultation form posts to its own URL and never to a separate endpoint.
 */
require __DIR__ . '/../app/bootstrap.php';

$made = 0;
foreach (registry() as $id => $entry) {
    $path = trim($entry['url'], '/');
    $dir  = $path === '' ? PF_ROOT : PF_ROOT . '/' . $path;
    if (in_array($id, ['error-404', 'error-500'], true)) {
        $dir = PF_ROOT . '/errors/' . str_replace('error-', '', $id);
    }
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $depth  = $dir === PF_ROOT ? 0 : substr_count(str_replace(PF_ROOT . '/', '', $dir), '/') + 1;
    $up     = str_repeat('/..', $depth);
    // render_page($id, $locale, $httpStatus). The locale is explicit in every
    // generated route so that a /es/ route differs from its English twin by
    // exactly one argument.
    $status = str_starts_with((string) $id, 'error-') ? ', ' . substr((string) $id, 6) : '';
    $handler = isset($entry['post_handler']) ? $entry['post_handler'] . "();\n" : '';
    $file    = $dir . '/index.php';
    $locale = default_locale();
    file_put_contents($file, "<?php\nrequire __DIR__ . '{$up}/app/bootstrap.php';\n{$handler}render_page('{$id}', '{$locale}'{$status});\n");
    $made++;
}
echo "Wrote {$made} route entrypoints.\n";
