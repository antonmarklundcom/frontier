<?php /** @var array $page
 * Preview-only banner. Never reaches a visitor: the renderer injects this block
 * solely when preview_mode() is true, which is impossible on a launched site.
 */ ?>
<div class="draftbar" role="status">
  <div class="wrap draftbar__inner">
    <span class="draftbar__tag">Draft outline</span>
    <p>
      Structure complete, copy unwritten. <strong><?= (int) ($page['draft_slots'] ?? 0) ?></strong>
      passage<?= ((int) ($page['draft_slots'] ?? 0)) === 1 ? '' : 's' ?> still marked ⟦&nbsp;like&nbsp;this&nbsp;⟧.
      This page is <code>noindex</code>, absent from the sitemap, and shows visitors the
      “in preparation” notice instead of what you are reading.
    </p>
  </div>
</div>
