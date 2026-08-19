<?php /** @var array $b
 * A decision table. Columns are the options; each row is one dimension people
 * actually decide on. Cells stack under their column label below 720px, so the
 * table never becomes a horizontal-scroll trap on a phone.
 *
 * 'caption' is required and is read by screen readers before the table.
 */
$cols = $b['columns'];
?>
<section class="cmp-sec" id="<?= e($b['id'] ?? 'comparison') ?>">
  <div class="wrap">
    <div class="cmp__head">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'Side by side') ?></p>
      <?php if (!empty($b['heading'])): ?><h2><?= e($b['heading']) ?></h2><?php endif; ?>
      <?php foreach ((array) ($b['intro_html'] ?? []) as $p): ?><p class="lede"><?= raw_html($p) ?></p><?php endforeach; ?>
    </div>

    <div class="cmp__scroll">
      <table class="cmp">
        <caption class="u-sr"><?= e($b['caption']) ?></caption>
        <thead>
          <tr>
            <th scope="col"><?= e($b['row_header'] ?? '') ?></th>
            <?php foreach ($cols as $c): ?><th scope="col"><?= e($c) ?></th><?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($b['rows'] as $row): ?>
            <tr>
              <th scope="row"><?= e($row['label']) ?></th>
              <?php foreach ($row['cells_html'] as $i => $cell): ?>
                <td data-col="<?= e($cols[$i] ?? '') ?>"><?= raw_html($cell) ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (!empty($b['footnote_html'])): ?><p class="cmp__foot"><?= raw_html($b['footnote_html']) ?></p><?php endif; ?>
  </div>
</section>
