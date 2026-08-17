<?php /** @var array $b — P8 full-bleed ribbon. Standards, not statistics: every
 * line is a verifiable policy, never a number we cannot support. */ ?>
<section class="ribbon grain on-ink" id="<?= e($b['id'] ?? 'standards') ?>">
  <div class="wrap">
    <div class="ribbon__grid">
      <?php foreach ($b['items'] as $item): ?>
        <div class="ribbon__item">
          <span class="ribbon__label"><?= e($item['label']) ?></span>
          <p class="ribbon__text"><?= e($item['text']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
