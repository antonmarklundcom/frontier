<?php /** @var array $b
 * The direct answer, at the top, before any context.
 *
 * Every guide leads with this: the reader's actual question answered in a few
 * sentences, with the caveat attached to the answer rather than hidden four
 * screens below it. 'answer' is one or more paragraphs; 'points' is an optional
 * short list of the load-bearing facts; 'caveat' is the condition under which
 * the answer changes, and is required — an answer with no stated limit is the
 * house style of the sites this one is written against.
 */
$points = $b['points'] ?? [];
?>
<section class="qa-sec" id="<?= e($b['id'] ?? 'answer') ?>">
  <div class="wrap">
    <div class="qanswer">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'The short answer') ?></p>
      <?php if (!empty($b['question'])): ?><h2 class="qanswer__q"><?= e($b['question']) ?></h2><?php endif; ?>
      <div class="qanswer__body">
        <?php foreach ((array) $b['answer'] as $p): ?><p><?= $p ?></p><?php endforeach; ?>
      </div>
      <?php if ($points): ?>
        <ul class="qanswer__points">
          <?php foreach ($points as $point): ?><li><?= $point ?></li><?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <?php if (!empty($b['caveat'])): ?>
        <p class="qanswer__caveat"><span>Where this stops being true</span> <?= $b['caveat'] ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
