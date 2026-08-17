<?php /** @var array $b @var array $page
 * Visible FAQs. FAQPage schema is emitted from $page['faqs'] in schema.php only
 * when this block actually renders them, so the markup and the structured data
 * can never disagree.
 */
$faqs = $page['faqs'] ?? [];
if (!$faqs) { return; }
?>
<section class="faq-sec" id="<?= e($b['id'] ?? 'faq') ?>">
  <div class="wrap split split--wide">
    <div class="split__aside">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'Questions') ?></p>
      <h2><?= e($b['heading'] ?? 'Common questions') ?></h2>
    </div>
    <div class="faq">
      <?php foreach ($faqs as $i => $f): ?>
        <details class="faq__item"<?= $i === 0 ? ' open' : '' ?>>
          <summary class="faq__q">
            <span><?= e($f['q']) ?></span>
            <svg class="faq__icon" width="14" height="14" viewBox="0 0 14 14" aria-hidden="true">
              <path d="M7 1v12M1 7h12" fill="none" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </summary>
          <div class="faq__a"><?php foreach ((array) $f['a'] as $p): ?><p><?= $p ?></p><?php endforeach; ?></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
