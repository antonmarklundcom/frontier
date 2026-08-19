<?php /** @var array $page */
$groups = navigation()['footer'];
$wa = whatsapp_link('footer');
$email = real('email');
?>
<footer class="foot grain">
  <div class="wrap">

    <div class="foot__top">
      <div class="foot__brand">
        <span class="wordmark__name wordmark__name--foot">Paraguay Frontier</span>
        <p class="foot__pitch"><?= e(t('footer_pitch')) ?></p>
        <ul class="foot__contact">
          <?php if ($email): ?><li><a href="mailto:<?= e($email) ?>" data-ev="email_click" data-ev-loc="footer"><?= e($email) ?></a></li><?php endif; ?>
          <?php if ($wa): ?><li><a href="<?= e($wa) ?>" rel="noopener" data-ev="whatsapp_click" data-ev-loc="footer"><?= e(t('whatsapp_label')) ?></a></li><?php endif; ?>
        </ul>
      </div>

      <div class="foot__cols">
        <?php foreach ($groups as $group): ?>
          <div class="foot__col">
            <h2 class="foot__head"><?= e($group['heading']) ?></h2>
            <ul>
              <?php foreach ($group['pages'] as $pid): $p = page($pid); if (!$p) continue; ?>
                <li><a href="<?= e(href($p['url'])) ?>"><?= e($p['nav_label'] ?? $p['h1']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="foot__bottom">
      <p class="foot__disclaimer"><strong><?= e(t('disclaimer_label')) ?></strong> <?= e(t('disclaimer')) ?></p>
      <p class="foot__legal">
        &copy; <?= e(date('Y')) ?> Paraguay Frontier.
        <?php if ($reg = real('company_reg')): ?><span><?= e($reg) ?></span><?php endif; ?>
      </p>
    </div>
  </div>
</footer>
