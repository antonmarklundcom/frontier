<?php /** @var array $b
 * Long-form section. 'heading' is optional; paragraphs and lists are separate
 * keys so content files never contain raw markup beyond inline emphasis.
 */ ?>
<section class="prose-sec" <?= !empty($b['id']) ? 'id="' . e($b['id']) . '"' : '' ?>>
  <div class="wrap split split--wide">
    <div class="split__aside">
      <?php if (!empty($b['eyebrow'])): ?><p class="eyebrow"><?= e($b['eyebrow']) ?></p><?php endif; ?>
      <?php if (!empty($b['heading'])): ?><h2><?= e($b['heading']) ?></h2><?php endif; ?>
    </div>
    <div class="prose">
      <?php foreach ($b['body'] as $part): ?>
        <?php if (is_string($part)): ?>
          <p><?= $part ?></p>
        <?php elseif (($part['type'] ?? '') === 'list'): ?>
          <ul class="prose__list">
            <?php foreach ($part['items'] as $item): ?><li><?= $item ?></li><?php endforeach; ?>
          </ul>
        <?php elseif (($part['type'] ?? '') === 'h3'): ?>
          <h3><?= e($part['text']) ?></h3>
        <?php elseif (($part['type'] ?? '') === 'defs'): ?>
          <dl class="defs">
            <?php foreach ($part['items'] as $d): ?>
              <div class="defs__row"><dt><?= e($d['term']) ?></dt><dd><?= $d['def'] ?></dd></div>
            <?php endforeach; ?>
          </dl>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
