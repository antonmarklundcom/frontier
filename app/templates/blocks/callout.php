<?php /** @var array $b — a caution, not a decoration. Signal Red is reserved
 * for this and for genuine warnings; it is never a design accent. */ ?>
<section class="callout-sec">
  <div class="wrap">
    <div class="callout callout--wide">
      <span class="callout__label"><?= e($b['label']) ?></span>
      <?php foreach ((array) $b['body'] as $p): ?><p><?= $p ?></p><?php endforeach; ?>
    </div>
  </div>
</section>
