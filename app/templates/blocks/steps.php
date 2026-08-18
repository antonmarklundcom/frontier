<?php /** @var array $b
 * An ordered sequence where each stage says who is acting.
 *
 * The 'who' tag is the point of the block. A reader's real question is rarely
 * "what are the steps" — it is "which of these am I waiting on, and which is
 * someone else's desk". Stages owned by the government carry no duration,
 * because we do not publish estimates for time we do not control.
 */ ?>
<section class="steps-sec" id="<?= e($b['id'] ?? 'sequence') ?>">
  <div class="wrap">
    <div class="steps__head">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'The sequence') ?></p>
      <?php if (!empty($b['heading'])): ?><h2><?= e($b['heading']) ?></h2><?php endif; ?>
      <?php foreach ((array) ($b['intro'] ?? []) as $p): ?><p class="lede"><?= $p ?></p><?php endforeach; ?>
    </div>

    <ol class="steps">
      <?php foreach ($b['items'] as $i => $s): ?>
        <li class="steps__item">
          <span class="steps__idx"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div class="steps__body">
            <h3><?= e($s['title']) ?></h3>
            <?php foreach ((array) $s['body'] as $p): ?><p><?= $p ?></p><?php endforeach; ?>
            <?php if (!empty($s['blocker'])): ?>
              <p class="steps__blocker"><span>Most common hold-up</span> <?= $s['blocker'] ?></p>
            <?php endif; ?>
          </div>
          <?php if (!empty($s['who'])): ?>
            <span class="tag steps__who tag--<?= e(strtolower(preg_replace('/[^a-z]/i', '', $s['who']))) ?>"><?= e($s['who']) ?></span>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>

    <?php if (!empty($b['footnote'])): ?><p class="steps__foot"><?= $b['footnote'] ?></p><?php endif; ?>
  </div>
</section>
