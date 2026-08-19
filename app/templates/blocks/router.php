<?php /** @var array $b
 * P10 — data panel. An interactive router, not a decorative widget: it turns
 * "I don't know where to start" into two or three specific links.
 *
 * Progressive enhancement: the server renders every pane visible and every
 * option as an in-page anchor, so with JavaScript disabled all six answers are
 * readable and every link works. site.js upgrades the list into a tablist and
 * hides the inactive panes.
 */ ?>
<section class="router" id="<?= e($b['id'] ?? 'start') ?>">
  <div class="wrap">
    <div class="router__head">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h2><?= e($b['heading']) ?></h2>
      <p class="lede"><?= e($b['lede']) ?></p>
    </div>

    <div class="router__panel" data-router>
      <ul class="router__options" data-router-options aria-label="<?= e($b['heading']) ?>">
        <?php foreach ($b['options'] as $i => $opt): ?>
          <li>
            <a class="router__opt" id="rtab-<?= e((string) $i) ?>" href="#rpane-<?= e((string) $i) ?>"
               data-ev="router_select" data-ev-loc="<?= e($opt['slug']) ?>">
              <span class="router__num"><?= e(str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
              <span><?= e($opt['label']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="router__body">
        <?php foreach ($b['options'] as $i => $opt): ?>
          <div class="router__pane" id="rpane-<?= e((string) $i) ?>" data-router-pane>
            <h3><?= e($opt['heading']) ?></h3>
            <p><?= e($opt['body']) ?></p>
            <ul class="router__links">
              <?php foreach ($opt['links'] as $link): $lp = page($link); ?>
                <li>
                  <a href="<?= e(href($lp['url'])) ?>" data-ev="router_link" data-ev-loc="<?= e($opt['slug']) ?>">
                    <span><?= e($lp['nav_label'] ?? $lp['h1']) ?></span>
                    <svg width="16" height="10" viewBox="0 0 16 10" aria-hidden="true"><path d="M10.5 1L15 5l-4.5 4M15 5H1" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
