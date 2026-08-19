<?php /** @var array $b — P3 staggered-weight grid. First card spans two columns
 * and uses card--ink; siblings use card--hair and card--accent. */ ?>
<section class="pathways" id="<?= e($b['id'] ?? 'services') ?>">
  <div class="wrap">
    <div class="router__head">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
      <?php if (!empty($b['lede'])): ?><p class="lede"><?= e($b['lede']) ?></p><?php endif; ?>
    </div>

    <div class="paths">
      <?php foreach ($b['items'] as $i => $item): $p = page($item['page']); ?>
        <a class="paths__item" href="<?= e(href($p['url'])) ?>" data-reveal="<?= e((string) $i) ?>"
           data-ev="service_click" data-ev-loc="pathways">
          <div class="card <?= e($item['variant']) ?>">
            <p class="paths__kicker"><?= e($item['kicker']) ?></p>
            <h3><?= e($item['title']) ?></h3>
            <p><?= e($item['body']) ?></p>
            <span class="paths__more">
              <?= e($item['more']) ?>
              <svg width="16" height="10" viewBox="0 0 16 10" aria-hidden="true"><path d="M10.5 1L15 5l-4.5 4M15 5H1" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
