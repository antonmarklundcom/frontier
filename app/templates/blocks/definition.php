<?php /** @var array $b
 * One term, defined properly — and then bounded by what it is *not*.
 *
 * The categories this site writes about are mis-sold mostly through blurred
 * definitions ("residency" standing in for four different things), so the
 * "commonly confused with" half of this block is not decoration; it is the
 * reason the block exists.
 */ ?>
<section class="def-sec" id="<?= e($b['id'] ?? 'definition') ?>">
  <div class="wrap split split--wide">
    <div class="split__aside">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'Definition') ?></p>
      <h2><?= e($b['term']) ?></h2>
    </div>
    <div class="def">
      <div class="def__main prose">
        <?php foreach ((array) $b['body_html'] as $p): ?><p><?= raw_html($p) ?></p><?php endforeach; ?>
      </div>
      <?php if (!empty($b['not_html'])): ?>
        <div class="def__not">
          <p class="def__notlabel"><?= e($b['not_label'] ?? 'What it is not') ?></p>
          <ul>
            <?php foreach ((array) $b['not_html'] as $item): ?><li><?= raw_html($item) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if (!empty($b['spanish'])): ?>
        <p class="def__native">In Paraguayan documents and offices this appears as
          <span lang="es"><?= e($b['spanish']) ?></span>.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
