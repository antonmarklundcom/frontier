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
$kind     = $key === 'tax_reviewer' ? 'Paraguayan accountant' : 'Paraguayan lawyer';
$date     = $page['last_reviewed'] ?? null;
?>
<section class="rev-sec">
  <div class="wrap">
    <div class="rev<?= $reviewer ? '' : ' rev--pending' ?>">
      <p class="rev__label"><?= $reviewer ? 'Professional review' : 'Not yet reviewed' ?></p>
      <?php if ($reviewer): ?>
        <p class="rev__body">
          This page was reviewed by <strong><?= e($reviewer) ?></strong><?= $date ? ' on <time datetime="' . e($date) . '">' . e(review_date($date)) . '</time>' : '' ?>.
          Review covers whether the procedure described matches current Paraguayan practice. It is not
          advice on your own situation, and it does not make this page a substitute for engaging a
          <?= e($kind) ?> on facts specific to you.
        </p>
      <?php else: ?>
        <p class="rev__body">
          A <?= e($kind) ?> has not yet reviewed this page, so it is not published: it is excluded from
          our sitemap and closed to search engines until that review happens. You are most likely reading
          it because you were sent a preview link. Treat every factual claim on it as unverified.
        </p>
      <?php endif; ?>
      <p class="rev__report">Found something wrong? Send us the URL and the sentence — corrections are
        made in the page with the review date changed, never quietly.</p>
    </div>
  </div>
</section>
