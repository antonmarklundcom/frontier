<?php /** @var array $page — honest state for a route that exists in the
 * architecture but has not been researched and reviewed yet. Never indexed. */ ?>
<section class="prep">
  <div class="wrap prep__inner">
    <span class="prep__badge"><?= e(t('in_preparation')) ?></span>
    <h1><?= e($page['h1']) ?></h1>
    <p class="lede"><?= e(t('in_preparation_body')) ?></p>
    <ul class="prep__links">
      <li><a href="/"><?= e(t('prep_link_home')) ?></a></li>
      <li><a href="<?= e(href(page_url('guides.residency'))) ?>"><?= e(t('prep_link_residency')) ?></a></li>
      <li><a href="<?= e(href(page_url('editorial-standards'))) ?>"><?= e(t('prep_link_editorial')) ?></a></li>
    </ul>
  </div>
</section>
