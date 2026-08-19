<?php /** @var array $b
 * The primary sources a page's claims rest on.
 *
 * Editorial standards promise a source hierarchy; this block is where a reader
 * checks that the promise was kept. A source whose URL has not been recorded
 * yet renders as text — the citation is still true, and inventing a plausible
 * government URL to make the block look finished is exactly the failure mode
 * this site is written against.
 */ ?>
<section class="src-sec" id="<?= e($b['id'] ?? 'sources') ?>">
  <div class="wrap split split--wide">
    <div class="split__aside">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? t('sources_heading')) ?></p>
      <h2><?= e($b['heading'] ?? 'What this page rests on') ?></h2>
    </div>
    <div class="src">
      <?php foreach ((array) ($b['intro_html'] ?? []) as $p): ?><p class="src__intro"><?= raw_html($p) ?></p><?php endforeach; ?>
      <ol class="src__list">
        <?php foreach ($b['items'] as $s): $url = $s['url'] ?? ''; ?>
          <li class="src__item">
            <span class="src__name">
              <?php if (!unwritten($url)): ?>
                <a href="<?= e($url) ?>" rel="nofollow noopener" target="_blank"><?= e($s['name']) ?></a>
              <?php else: ?>
                <?= e($s['name']) ?>
              <?php endif; ?>
            </span>
            <?php if (!empty($s['authority'])): ?><span class="src__auth"><?= e($s['authority']) ?></span><?php endif; ?>
            <?php if (!empty($s['note_html'])): ?><span class="src__note"><?= raw_html($s['note_html']) ?></span><?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="src__policy"><?= e(t('sources_policy')) ?></p>
    </div>
  </div>
</section>
