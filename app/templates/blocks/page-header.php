<?php /** @var array $b @var array $page
 * Interior page header. Carries the H1, the intro, and the document metadata
 * strip (last reviewed / author / reviewer) that the editorial standards page
 * promises every page will show.
 */
$reviewer = real($b['reviewer_key'] ?? '');
$author   = real('founder');
?>
<section class="phead">
  <div class="wrap"><div class="phead__inner">
    <?php if (!empty($b['eyebrow'])): ?><p class="eyebrow"><?= e($b['eyebrow']) ?></p><?php endif; ?>
    <h1><?= e($page['h1']) ?></h1>
    <?php if (!empty($b['intro'])): ?><p class="lede"><?= e($b['intro']) ?></p><?php endif; ?>

    <dl class="stamp">
      <?php if (!empty($page['last_reviewed'])): ?>
        <div class="stamp__pair">
          <dt><?= e(t('last_reviewed')) ?></dt>
          <dd><time datetime="<?= e($page['last_reviewed']) ?>"><?= e(review_date($page['last_reviewed'])) ?></time></dd>
        </div>
      <?php endif; ?>
      <?php if ($author): ?>
        <div class="stamp__pair"><dt><?= e(t('stamp_written_by')) ?></dt><dd><?= e($author) ?></dd></div>
      <?php endif; ?>
      <?php if ($reviewer): ?>
        <div class="stamp__pair"><dt><?= e(t('stamp_reviewed_by')) ?></dt><dd><?= e($reviewer) ?></dd></div>
      <?php endif; ?>
    </dl>
  </div></div>
</section>
