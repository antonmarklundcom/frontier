<?php /** @var array $b — one natural next step, plus the neighbouring pages. */ ?>
<section class="related-sec">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('related_heading')) ?></p>
    <div class="related">
      <?php foreach ($b['items'] as $item): $p = page($item['page']); if (!$p) { continue; } ?>
        <a class="related__item" href="<?= e(href($p['url'])) ?>" data-ev="related_click" data-ev-loc="<?= e($p['id']) ?>">
          <h3><?= e($p['nav_label'] ?? $p['h1']) ?></h3>
          <p><?= e($item['note'] ?? $p['description']) ?></p>
          <span class="guides__stamp">
            <?= /* Both branches are escaped or literal: trusted by construction. */
                raw_html($p['status'] === 'live' && !empty($p['last_reviewed'])
                ? e(t('last_reviewed')) . ' ' . e(review_date($p['last_reviewed']))
                : e(t('nav_state_in_preparation'))) ?>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
