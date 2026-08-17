<?php /** @var array $b — P1 mirrored (5/7). No scarcity, no countdown, no
 * "limited slots". The list says who the call is for and who it is not for. */
$wa = whatsapp_link('consultation');
?>
<section class="cta spacer-after-overlap" id="<?= e($b['id'] ?? 'consultation') ?>">
  <div class="wrap cta__grid">
    <div class="cta__card grain on-ink">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
      <p style="color:var(--on-ink-70)"><?= e($b['body']) ?></p>
      <div class="cta__actions">
        <a class="btn btn--primary" href="<?= e(href(page_url($b['cta']['page']))) ?>"
           data-ev="book_click" data-ev-loc="footer_cta"><?= e($b['cta']['label']) ?></a>
        <?php if ($wa): ?>
          <a class="btn btn--ghost" href="<?= e($wa) ?>" rel="noopener"
             data-ev="whatsapp_click" data-ev-loc="footer_cta">WhatsApp</a>
        <?php endif; ?>
      </div>
    </div>

    <div>
      <h3><?= e($b['list_heading']) ?></h3>
      <ul class="cta__list">
        <?php foreach ($b['covered'] as $row): ?>
          <li>
            <span class="meta"><?= e($row['tag']) ?></span>
            <span><?= e($row['text']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="callout" style="margin-top:var(--s-8)">
        <span class="callout__label"><?= e($b['note']['label']) ?></span>
        <p><?= e($b['note']['text']) ?></p>
      </div>
    </div>
  </div>
</section>
