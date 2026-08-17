<?php /** @var array $b @var array $page
 * Hero — P1 asymmetric split (7/5), ink field, full-bleed.
 * The contour layer is a texture, not a map: no labels, no place markers, no
 * claim to represent real geography. It drifts on desktop only.
 */ ?>
<section class="hero grain on-ink" id="<?= e($b['id'] ?? 'top') ?>">
  <div class="hero__contours" data-drift aria-hidden="true">
    <svg width="100%" height="100%" viewBox="0 0 1200 700" preserveAspectRatio="xMidYMid slice" focusable="false">
      <g fill="none" stroke="currentColor" stroke-width="1" opacity=".22">
        <path d="M-40 610C160 560 300 640 470 590S760 470 940 512s230 26 340-24"/>
        <path d="M-40 556C170 502 306 584 476 532S762 410 942 452s228 26 338-26"/>
        <path d="M-40 502C180 444 312 528 482 474S764 350 944 392s226 26 336-28"/>
        <path d="M-40 448C190 386 318 472 488 416S766 290 946 332s224 26 334-30"/>
        <path d="M-40 394C200 328 324 416 494 358S768 230 948 272s222 26 332-32"/>
        <path d="M-40 340C210 270 330 360 500 300S770 170 950 212s220 26 330-34"/>
      </g>
      <g fill="none" stroke="currentColor" stroke-width="1" opacity=".13">
        <path d="M-40 286C220 212 336 304 506 242S772 110 952 152s218 26 328-36"/>
        <path d="M-40 232C230 154 342 248 512 184S774 50 954 92s216 26 326-38"/>
        <path d="M-40 178C240 96 348 192 518 126S776-10 956 32s214 26 324-40"/>
        <path d="M-40 124C250 38 354 136 524 68S778-70 958-28s212 26 322-42"/>
      </g>
    </svg>
  </div>

  <div class="wrap hero__grid">
    <div class="hero__text">
      <p class="eyebrow"><?= e($b['eyebrow']) ?></p>
      <h1><?= $b['h1_html'] ?></h1>
      <p class="hero__lede"><?= e($b['lede']) ?></p>

      <div class="hero__actions">
        <a class="btn btn--primary" href="<?= e(href(page_url($b['cta_primary']['page']))) ?>"
           data-ev="cta_click" data-ev-loc="hero">
          <?= e($b['cta_primary']['label']) ?>
          <svg class="btn__arrow" width="16" height="10" viewBox="0 0 16 10" aria-hidden="true"><path d="M10.5 1L15 5l-4.5 4M15 5H1" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
        </a>
        <a class="btn btn--ghost" href="<?= e(href(page_url($b['cta_secondary']['page']))) ?>"
           data-ev="book_click" data-ev-loc="hero"><?= e($b['cta_secondary']['label']) ?></a>
      </div>

      <p class="hero__note"><?= e($b['note']) ?></p>
    </div>

    <div class="hero__aside">
      <div class="route" data-route>
        <div class="route__head">
          <span class="route__title"><?= e($b['route']['title']) ?></span>
          <span class="route__title"><?= e($b['route']['stamp']) ?></span>
        </div>
        <ol class="route__stages">
          <span class="route__line" aria-hidden="true"><i></i></span>
          <?php foreach ($b['route']['stages'] as $stage): ?>
            <li class="route__stage">
              <span class="route__dot" aria-hidden="true"></span>
              <span>
                <span class="route__name"><?= e($stage['name']) ?></span>
                <span class="route__who"><?= e($stage['who']) ?></span>
              </span>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="route__foot"><?= e($b['route']['foot']) ?></p>
      </div>
    </div>
  </div>
</section>
