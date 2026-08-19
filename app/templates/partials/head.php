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

<meta property="og:type" content="<?= e(($page['type'] ?? '') === 'article' ? 'article' : 'website') ?>">
<meta property="og:site_name" content="<?= e((string) site('name')) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:locale" content="<?= e(og_locale(locale())) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($page['title']) ?>">
<meta name="twitter:description" content="<?= e($page['description']) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<?php
/* hreflang emits itself. locale_alternates() returns the other locales in
   which THIS page id is live — and only one locale is configured today, so it
   returns nothing and not a single tag is printed. Advertising an alternate
   that 404s, or that resolves to an in-preparation notice, is worse than
   having no alternate at all; because the list is derived rather than
   maintained, that cannot happen by omission.

   Reciprocity is automatic: both sides derive their tags from the same
   registries. See docs/TRANSLATION-ARCHITECTURE.md §5. */
$alternates = locale_alternates($page['id'], locale());
if ($alternates !== []):
    foreach ($alternates as $altLocale => $altUrl): ?>
<link rel="alternate" hreflang="<?= e(locale_lang($altLocale)) ?>" href="<?= e($altUrl) ?>">
<?php endforeach; ?>
<link rel="alternate" hreflang="<?= e(locale_lang(locale())) ?>" href="<?= e($canonical) ?>">
<link rel="alternate" hreflang="x-default" href="<?= e(url(page_url($page['id'], default_locale()))) ?>">
<?php endif; ?>

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

<script type="application/ld+json"><?= raw_html(json_encode(schema_graph($page, $crumbs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?></script>
</head>
