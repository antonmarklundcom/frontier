<?php /** @var array $b — P6 bleed overlap: the panel crosses into the next
 * section. Cornerstone guides are selected by hand, never auto-listed. */ ?>
<section class="guides grain on-ink" id="<?= e($b['id'] ?? 'guides') ?>">
  <div class="wrap">
    <div class="router__head">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
    </div>
    <div class="guides__panel" data-reveal="0">
      <div class="guides__list">
        <?php foreach ($b['items'] as $item): $p = page($item['page']); ?>
          <a class="guides__item" href="<?= e(href($p['url'])) ?>" data-ev="guide_click" data-ev-loc="cornerstone">
            <h3><?= e($p['h1']) ?></h3>
            <p><?= e($item['summary']) ?></p>
            <span class="guides__stamp">
              <?php if ($p['status'] === 'live' && !empty($p['last_reviewed'])): ?>
                <?= e(t('last_reviewed')) ?> <?= e(review_date($p['last_reviewed'])) ?>
              <?php else: ?>
                In preparation
              <?php endif; ?>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
