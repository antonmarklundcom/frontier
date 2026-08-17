<?php /** @var array $page @var array $crumbs */
$canonical = url($page['url']);
$ogImage   = og_image($page);
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['description']) ?>">
<meta name="robots" content="<?= e(robots_directive($page)) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">

<meta property="og:type" content="<?= ($page['type'] ?? '') === 'article' ? 'article' : 'website' ?>">
<meta property="og:site_name" content="<?= e((string) site('name')) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:locale" content="en">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($page['title']) ?>">
<meta name="twitter:description" content="<?= e($page['description']) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<?php /* Spanish hreflang is intentionally absent: no /es/ page exists yet, and
         advertising one that 404s is worse than having no alternate at all.
         See docs/TRANSLATION-ARCHITECTURE.md for the switch-on procedure. */ ?>

<link rel="icon" href="<?= e(asset('assets/images/favicon.svg')) ?>" type="image/svg+xml">
<link rel="manifest" href="/manifest.webmanifest">
<meta name="theme-color" content="#081D24">

<link rel="preload" href="/assets/fonts/Archivo-400_700-latin.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/fonts/IBMPlexSans-400-latin.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(asset('assets/css/site.css')) ?>">

<!-- ANALYTICS: paste GTM or GA4 here. Events already fire via the data-ev shim. -->
<!-- SEARCH-CONSOLE: verify by DNS TXT record, not by meta tag. -->
<script>
(function(){
  window.dataLayer = window.dataLayer || [];
  document.addEventListener('click', function(e){
    var t = e.target.closest('[data-ev]');
    if (!t) return;
    window.dataLayer.push({
      event: t.dataset.ev,
      ev_loc: t.dataset.evLoc || '',
      page_path: location.pathname,
      site: location.hostname
    });
  }, true);
})();
</script>

<script type="application/ld+json"><?= json_encode(schema_graph($page, $crumbs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
</head>
