<?php /** @var array $b — one natural next step, plus the neighbouring pages. */ ?>
<section class="related-sec">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('related_heading')) ?></p>
    <div class="related">
      <?php foreach ($b['items'] as $item): $p = page($item['page']); ?>
        <a class="related__item" href="<?= e(href($p['url'])) ?>" data-ev="related_click" data-ev-loc="<?= e($p['id']) ?>">
          <h3><?= e($p['nav_label'] ?? $p['h1']) ?></h3>
          <p><?= e($item['note'] ?? $p['description']) ?></p>
          <span class="guides__stamp">
            <?= $p['status'] === 'live' && !empty($p['last_reviewed'])
                ? e(t('last_reviewed')) . ' ' . e(review_date($p['last_reviewed']))
                : 'In preparation' ?>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
