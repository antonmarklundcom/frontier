<?php /** @var array $crumbs */ ?>
<nav class="crumbs" aria-label="Breadcrumb">
  <div class="wrap">
    <ol class="crumbs__list">
      <?php $last = count($crumbs) - 1;
      foreach ($crumbs as $i => $c): ?>
        <li class="crumbs__item">
          <?php if ($i === $last): ?>
            <span aria-current="page"><?= e($c['label']) ?></span>
          <?php else: ?>
            <a href="<?= e(href($c['url'])) ?>"><?= e($c['label']) ?></a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</nav>
