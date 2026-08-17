<?php /** @var array $b — P5 numbered process rail on an ink field. */ ?>
<section class="journey grain on-ink" id="<?= e($b['id'] ?? 'journey') ?>">
  <div class="wrap">
    <div class="router__head">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
      <p class="hero__lede"><?= e($b['lede']) ?></p>
    </div>

    <div class="journey__grid" style="margin-top:var(--s-12)">
      <?php foreach ($b['steps'] as $i => $step): ?>
        <div class="journey__step" data-reveal="<?= $i ?>">
          <p class="journey__who"><?= e($step['who']) ?></p>
          <h3><?= e($step['title']) ?></h3>
          <p class="journey__note"><?= e($step['note']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
