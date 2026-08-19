<?php
/**
 * Paraguay Frontier — single entry point for every public route.
 *
 * Each public URL is a directory holding an index.php of two lines:
 *     require __DIR__ . '/../app/bootstrap.php';
 *     render_page('guides.residency');
 *
 * Everything else — metadata, schema, navigation, layout, blocks — is resolved
 * from the content registry. Adding page 130 means adding one content file and
 * one two-line index.php, never touching a template.
 */

declare(strict_types=1);

define('PF_ROOT', dirname(__DIR__));
define('PF_APP', __DIR__);

// Direct HTTP access to anything under /app is meaningless and is blocked by
// .htaccess; this is the belt-and-braces guard for hosts that ignore it.
if (!defined('PF_ENTRY')) {
    define('PF_ENTRY', true);
}

mb_internal_encoding('UTF-8');

$configFile = PF_ROOT . '/config/site.php';
$GLOBALS['PF_SITE'] = require (is_file($configFile) ? $configFile : PF_ROOT . '/config/site.example.php');

require PF_APP . '/helpers.php';
// Installed before anything else can fail: from here on a web request that
// throws renders the 500 page instead of a stack trace. See app/errors.php.
require PF_APP . '/errors.php';
require PF_APP . '/seo.php';
require PF_APP . '/draft.php';
require PF_APP . '/schema.php';
require PF_APP . '/page-renderer.php';
require PF_APP . '/form.php';
