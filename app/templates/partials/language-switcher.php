<?php /** @var array $page
 * The language switcher, dormant until a second locale is configured.
 *
 * Renders nothing at all while config['locales'] holds one entry — not an
 * empty element, not a disabled control. A switcher with one option is noise.
 *
 * Rules it enforces, from docs/TRANSLATION-ARCHITECTURE.md §5:
 *   - links to the SAME page in the other locale when that page is live there;
 *   - links to the other locale's home page when it is not, never to an
 *     in-preparation notice;
 *   - never redirects automatically by Accept-Language or by IP. A visitor
 *     researching a legal process must not be silently moved off the page they
 *     chose. This control is the only mechanism, and the visitor operates it.
 */
if (count(locales()) < 2) {
    return;
}
$current    = locale();
$alternates = locale_alternates($page['id'], $current);
?>
<nav class="langs" aria-label="<?= e(t('language_switcher_label')) ?>">
  <ul class="langs__list">
    <?php foreach (locales() as $loc): ?>
      <?php if ($loc === $current): ?>
        <li class="langs__item langs__item--current" aria-current="true"><?= e(t('language_name', $loc)) ?></li>
      <?php else: ?>
        <?php
        // No live translation of this page: the other locale's home page is
        // the honest destination. Anything else advertises a page that is not
        // there.
        $target = $alternates[$loc] ?? url(page_url('home', $loc));
        ?>
        <li class="langs__item">
          <a href="<?= e($target) ?>" hreflang="<?= e(locale_lang($loc)) ?>" lang="<?= e(locale_lang($loc)) ?>"><?= e(t('language_name', $loc)) ?></a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</nav>
