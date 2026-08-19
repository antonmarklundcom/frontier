<?php /**
 * Every page() lookup in this file is guarded against null. tools/qa.php fails
 * the build on an unresolvable navigation id, so a null here should be
 * impossible — but while it was unguarded, one typo'd id raised a TypeError
 * inside href() and took down every page on the site, the header being on all
 * of them. A skipped menu entry is a bad day; a site-wide 500 is a different
 * kind of day.
 * @var array $page */
$nav = navigation()['primary'];
$onDark = ($page['hero_theme'] ?? 'light') === 'ink';
?>
<header class="masthead <?= e($onDark ? 'masthead--over-dark' : '') ?>" data-sticky-header>
  <div class="masthead__inner wrap">

    <a class="wordmark" href="/" aria-label="<?= e(t('wordmark_home_aria')) ?>">
      <svg class="wordmark__mark" width="26" height="26" viewBox="0 0 26 26" aria-hidden="true" focusable="false">
        <circle cx="13" cy="13" r="11.25" fill="none" stroke="currentColor" stroke-width="1.5"/>
        <path d="M13 1.75V24.25M1.75 13H24.25" stroke="currentColor" stroke-width="1" opacity=".45"/>
        <circle cx="13" cy="13" r="3.5" fill="var(--accent)"/>
      </svg>
      <span class="wordmark__text">
        <span class="wordmark__name">Paraguay Frontier</span>
        <span class="wordmark__line"><?= e(t('brand_line')) ?></span>
      </span>
    </a>

    <nav class="nav" aria-label="<?= e(t('nav_primary_label')) ?>">
      <ul class="nav__list">
        <?php foreach ($nav as $i => $item):
            $hasPanel = !empty($item['children']); ?>
          <li class="nav__item <?= e($hasPanel ? 'nav__item--has-panel' : '') ?>">
            <?php if ($hasPanel): ?>
              <button type="button" class="nav__link" aria-expanded="false" aria-controls="navpanel-<?= e((string) $i) ?>">
                <?= e($item['label']) ?>
                <svg class="nav__chev" width="10" height="6" viewBox="0 0 10 6" aria-hidden="true"><path d="M1 1l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>
              </button>
              <div class="panel" id="navpanel-<?= e((string) $i) ?>" hidden>
                <ul class="panel__list">
                  <?php foreach ($item['children'] as $child): $cp = page($child['page']); if (!$cp) { continue; } ?>
                    <li>
                      <a class="panel__link" href="<?= e(href($cp['url'])) ?>">
                        <span class="panel__label"><?= e($child['label']) ?></span>
                        <?php if ($cp['status'] !== 'live'): ?><span class="panel__state"><?= e(t('nav_state_in_preparation')) ?></span><?php endif; ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php else: ?>
              <a class="nav__link" href="<?= e(href(page_url($item['page']))) ?>"><?= e($item['label']) ?></a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="masthead__actions">
      <a class="btn btn--primary btn--sm" href="<?= e(href(page_url('book'))) ?>"
         data-ev="book_click" data-ev-loc="header"><?= e(t('nav_book')) ?></a>
      <button type="button" class="burger" aria-expanded="false" aria-controls="mobile-nav">
        <span class="burger__box" aria-hidden="true"><span></span><span></span><span></span></span>
        <span class="u-sr"><?= e(t('menu_open')) ?></span>
      </button>
    </div>
  </div>
</header>

<div class="drawer" id="mobile-nav" hidden>
  <nav class="drawer__inner" aria-label="<?= e(t('nav_mobile_label')) ?>">
    <?php foreach ($nav as $item): ?>
      <?php $top = page($item['page']); if (!$top) { continue; } ?>
      <div class="drawer__group">
        <a class="drawer__head" href="<?= e(href($top['url'])) ?>"><?= e($item['label']) ?></a>
        <?php if (!empty($item['children'])): ?>
          <ul class="drawer__list">
            <?php foreach ($item['children'] as $child): ?>
              <li><a href="<?= e(href(page_url($child['page']))) ?>"><?= e($child['label']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <a class="btn btn--primary drawer__cta" href="<?= e(href(page_url('book'))) ?>"
       data-ev="book_click" data-ev-loc="mobile_menu"><?= e(t('nav_book')) ?></a>
  </nav>
</div>
