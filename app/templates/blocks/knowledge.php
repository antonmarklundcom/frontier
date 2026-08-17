<?php /** @var array $b — P7 sticky-side scroll. */ ?>
<section class="know-sec" id="<?= e($b['id'] ?? 'knowledge') ?>">
  <div class="wrap know">
    <div class="know__aside">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
      <p><?= e($b['lede']) ?></p>
      <a class="linkish" href="<?= e(href(page_url($b['cta']['page']))) ?>" data-ev="guide_click" data-ev-loc="knowledge">
        <?= e($b['cta']['label']) ?>
        <svg width="16" height="10" viewBox="0 0 16 10" aria-hidden="true"><path d="M10.5 1L15 5l-4.5 4M15 5H1" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
      </a>
    </div>

    <div class="know__list">
      <?php foreach ($b['items'] as $i => $item): $p = page($item['page']); ?>
        <a class="know__item" href="<?= e(href($p['url'])) ?>" data-ev="guide_click" data-ev-loc="knowledge">
          <span class="know__idx"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span>
            <span class="know__name"><?= e($item['title']) ?></span>
            <span class="know__desc"><?= e($item['body']) ?></span>
          </span>
          <svg class="know__arrow" width="18" height="11" viewBox="0 0 16 10" aria-hidden="true"><path d="M10.5 1L15 5l-4.5 4M15 5H1" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
