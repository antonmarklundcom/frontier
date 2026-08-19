<?php /** @var array $b @var array $page
 * The review stamp at the foot of a guide.
 *
 * This block cannot lie about review status: it reads the reviewer's name from
 * configuration, and while that value is still a placeholder it renders the
 * honest state — reviewed by nobody, therefore not published — rather than a
 * vague "reviewed by our experts". The same condition keeps the page noindex
 * elsewhere in the code, so the badge and the robots header always agree.
 */
$key      = $b['reviewer_key'] ?? 'legal_reviewer';
$reviewer = real($key);
$kind     = t($key === 'tax_reviewer' ? 'reviewer_kind_accountant' : 'reviewer_kind_lawyer');
$date     = $page['last_reviewed'] ?? null;
?>
<section class="rev-sec">
  <div class="wrap">
    <div class="rev<?= e($reviewer ? '' : ' rev--pending') ?>">
      <p class="rev__label"><?= e(t($reviewer ? 'reviewer_label_reviewed' : 'reviewer_label_pending')) ?></p>
      <?php if ($reviewer): ?>
        <p class="rev__body"><?= raw_html(t_format('reviewer_body_html',
          '<strong>' . e($reviewer) . '</strong>',
          $date ? ' on <time datetime="' . e($date) . '">' . e(review_date($date)) . '</time>' : '',
          e($kind))) ?></p>
      <?php else: ?>
        <p class="rev__body"><?= e(t_format('reviewer_body_pending', $kind)) ?></p>
      <?php endif; ?>
      <p class="rev__report"><?= e(t('reviewer_report')) ?></p>
    </div>
  </div>
</section>
