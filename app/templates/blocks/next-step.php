<?php /** @var array $b
 * The quiet foot-of-guide call to action.
 *
 * The heavy consultation-cta block belongs on the home page and the commercial
 * pages. A guide ends with this instead: one sentence, one link, and — where it
 * applies — the honest note that the reader may not need us at all. That note
 * is a field on the block because several guides are supposed to carry it.
 */ ?>
<section class="next-sec" id="<?= e($b['id'] ?? 'next') ?>">
  <div class="wrap">
    <div class="next">
      <div class="next__text">
        <p class="eyebrow"><?= e($b['eyebrow'] ?? 'Next step') ?></p>
        <h2><?= e($b['heading']) ?></h2>
        <?php foreach ((array) $b['body_html'] as $p): ?><p><?= raw_html($p) ?></p><?php endforeach; ?>
      </div>
      <div class="next__act">
        <a class="btn btn--primary" href="<?= e(href(page_url($b['cta']['page']))) ?>"
           data-ev="book_click" data-ev-loc="<?= e($b['id'] ?? 'guide_foot') ?>"><?= e($b['cta']['label']) ?></a>
        <?php if (!empty($b['secondary'])): ?>
          <a class="linkish" href="<?= e(href(page_url($b['secondary']['page']))) ?>"><?= e($b['secondary']['label']) ?></a>
        <?php endif; ?>
      </div>
    </div>
    <?php if (!empty($b['diy_html'])): ?>
      <p class="next__diy"><?= raw_html($b['diy_html']) ?></p>
    <?php endif; ?>
  </div>
</section>
