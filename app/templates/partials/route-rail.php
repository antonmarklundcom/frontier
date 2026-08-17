<?php /** @var array $page
 * Frontier Route rail — the site's signature orientation device.
 *
 * It is not decoration: each marker is a real section of the page, the progress
 * line reflects real scroll position, and the whole thing is a labelled in-page
 * navigation list. It is hidden below 1280px (where it would compete with
 * content) and it is inert without JavaScript, because the same sections are
 * reachable by scrolling.
 */
$rail = $page['rail'] ?? [];
if (!$rail) { return; }
?>
<nav class="rail" aria-label="Page sections" data-rail>
  <span class="rail__track" aria-hidden="true"><span class="rail__progress" data-rail-progress></span></span>
  <ol class="rail__list">
    <?php foreach ($rail as $i => $stop): ?>
      <li class="rail__stop">
        <a class="rail__link" href="#<?= e($stop['target']) ?>" data-rail-link="<?= e($stop['target']) ?>">
          <span class="rail__marker" aria-hidden="true"></span>
          <span class="rail__index" aria-hidden="true"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="rail__label"><?= e($stop['label']) ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
