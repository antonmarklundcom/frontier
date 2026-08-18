<?php /** @var array $b
 * A checklist meant to be used, printed and sent to a spouse — the most
 * linkable asset in this category and the one competitors do worst.
 *
 * Each item can carry who is responsible for it and how long the record stays
 * valid, because the expensive mistake in Paraguayan document preparation is
 * ordering the right papers in the wrong order and watching one expire.
 */
$groups = $b['groups'] ?? [];
?>
<section class="check-sec" id="<?= e($b['id'] ?? 'checklist') ?>">
  <div class="wrap">
    <div class="check__head">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'Checklist') ?></p>
      <?php if (!empty($b['heading'])): ?><h2><?= e($b['heading']) ?></h2><?php endif; ?>
      <?php foreach ((array) ($b['intro'] ?? []) as $p): ?><p class="lede"><?= $p ?></p><?php endforeach; ?>
    </div>

    <?php foreach ($groups as $g): ?>
      <div class="check__group">
        <h3 class="check__gtitle"><?= e($g['title']) ?></h3>
        <?php if (!empty($g['note'])): ?><p class="check__gnote"><?= $g['note'] ?></p><?php endif; ?>
        <ul class="check__list">
          <?php foreach ($g['items'] as $item): ?>
            <li class="check__item">
              <span class="check__box" aria-hidden="true"></span>
              <span class="check__text">
                <span class="check__name"><?= $item['item'] ?></span>
                <?php if (!empty($item['note'])): ?><span class="check__note"><?= $item['note'] ?></span><?php endif; ?>
              </span>
              <span class="check__meta">
                <?php if (!empty($item['who'])): ?><span class="tag"><?= e($item['who']) ?></span><?php endif; ?>
                <?php if (!empty($item['validity'])): ?><span class="check__valid"><?= e($item['validity']) ?></span><?php endif; ?>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>

    <?php if (!empty($b['footnote'])): ?>
      <p class="check__foot"><?= $b['footnote'] ?></p>
    <?php endif; ?>
  </div>
</section>
