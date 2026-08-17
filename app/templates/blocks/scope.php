<?php /** @var array $b — P4 editorial two-column. The two lists are the honest
 * scope boundary: what we do, and what we deliberately do not claim. */ ?>
<section class="scope-sec" id="<?= e($b['id'] ?? 'scope') ?>">
  <div class="wrap split">
    <div class="split__aside">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
    </div>
    <div>
      <p class="lede"><?= e($b['lede']) ?></p>

      <div class="scope" style="margin-top:var(--s-10)">
        <div class="card card--hair">
          <h4><?= e($b['yes_heading']) ?></h4>
          <ul class="scope__list">
            <?php foreach ($b['yes'] as $line): ?>
              <li><span class="scope__mark scope__mark--yes" aria-hidden="true">+</span><span><?= e($line) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="card card--hair">
          <h4><?= e($b['no_heading']) ?></h4>
          <ul class="scope__list">
            <?php foreach ($b['no'] as $line): ?>
              <li><span class="scope__mark scope__mark--no" aria-hidden="true">&minus;</span><span><?= e($line) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <?php if (!empty($b['callout'])): ?>
        <div class="callout" style="margin-top:var(--s-8)">
          <span class="callout__label"><?= e($b['callout']['label']) ?></span>
          <p><?= e($b['callout']['text']) ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
