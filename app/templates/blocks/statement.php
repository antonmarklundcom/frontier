<?php /** @var array $b — P9 oversized statement. One per page. */ ?>
<section class="statement-sec" id="<?= e($b['id'] ?? 'integrity') ?>">
  <div class="wrap">
    <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
    <p class="statement"><?= raw_html($b['statement_html']) ?></p>
    <div class="statement-sec__foot">
      <p class="lede"><?= e($b['body']) ?></p>
      <a class="btn btn--ghost" href="<?= e(href(page_url($b['cta']['page']))) ?>"
         data-ev="integrity_click" data-ev-loc="statement"><?= e($b['cta']['label']) ?></a>
    </div>
  </div>
</section>
