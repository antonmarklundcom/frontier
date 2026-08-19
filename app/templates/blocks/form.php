<?php /** @var array $b @var array $page
 * The consultation enquiry form.
 *
 * When no delivery address is configured the form renders read-only with the
 * reason stated, rather than accepting messages into nowhere. Everything the
 * handler checks — token, stamp, honeypot — is emitted here; see app/form.php.
 */
$state    = form_state();
$errors   = $state['errors'];
$old      = $state['old'];
$enabled  = form_enabled();
$val      = fn(string $k) => (string) ($old[$k] ?? '');
$err      = fn(string $k) => $errors[$k] ?? '';
?>
<section class="form-sec" id="<?= e($b['id'] ?? 'enquiry') ?>">
  <div class="wrap split split--wide">
    <div class="split__aside">
      <p class="eyebrow"><?= e($b['eyebrow'] ?? 'Enquiry') ?></p>
      <?php if (!empty($b['heading'])): ?><h2><?= e($b['heading']) ?></h2><?php endif; ?>
      <?php foreach ((array) ($b['intro_html'] ?? []) as $p): ?><p><?= raw_html($p) ?></p><?php endforeach; ?>
    </div>

    <div class="formwrap">
      <?php if (!$enabled): ?>
        <div class="callout callout--warn">
          <span class="callout__label">This form is not live yet</span>
          <p>Message delivery has not been configured and verified on this server, so the form is
             switched off rather than silently discarding what you write. Use the contact details in
             the footer instead — they are checked.</p>
        </div>
      <?php elseif (!empty($err('form'))): ?>
        <div class="callout callout--warn" role="alert">
          <span class="callout__label">Not sent</span>
          <p><?= e($err('form')) ?></p>
        </div>
      <?php endif; ?>

      <form class="form" method="post" action="<?= e(href(page_url('book'))) ?>#enquiry" novalidate>
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="stamp" value="<?= e(form_stamp()) ?>">
        <!-- Honeypot: hidden from people, irresistible to form-filling scripts. -->
        <div class="form__hp" aria-hidden="true">
          <label for="company_website">Company website</label>
          <input type="text" id="company_website" name="company_website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form__row">
          <label class="form__label" for="f-name">Your name <span class="form__req">required</span></label>
          <input class="form__input<?= e($err('name') ? ' is-error' : '') ?>" type="text" id="f-name" name="name"
                 autocomplete="name" required value="<?= e($val('name')) ?>" <?= raw_html($enabled ? '' : 'disabled') ?>
                 <?= raw_html($err('name') ? 'aria-describedby="e-name" aria-invalid="true"' : '') ?>>
          <?php if ($err('name')): ?><p class="form__err" id="e-name"><?= e($err('name')) ?></p><?php endif; ?>
        </div>

        <div class="form__row">
          <label class="form__label" for="f-email">Email <span class="form__req">required</span></label>
          <input class="form__input<?= e($err('email') ? ' is-error' : '') ?>" type="email" id="f-email" name="email"
                 autocomplete="email" required value="<?= e($val('email')) ?>" <?= raw_html($enabled ? '' : 'disabled') ?>
                 <?= raw_html($err('email') ? 'aria-describedby="e-email" aria-invalid="true"' : '') ?>>
          <?php if ($err('email')): ?><p class="form__err" id="e-email"><?= e($err('email')) ?></p><?php endif; ?>
        </div>

        <div class="form__grid">
          <div class="form__row">
            <label class="form__label" for="f-country">Your nationality</label>
            <input class="form__input" type="text" id="f-country" name="country" autocomplete="country-name"
                   value="<?= e($val('country')) ?>" <?= raw_html($enabled ? '' : 'disabled') ?>>
            <p class="form__hint">Nationality changes which records you need and how they are authenticated.</p>
          </div>
          <div class="form__row">
            <label class="form__label" for="f-stage">Where you are</label>
            <select class="form__input" id="f-stage" name="stage" <?= raw_html($enabled ? '' : 'disabled') ?>>
              <?php
              $stages = [
                  '' => 'Select one',
                  'researching'  => 'Researching — no decision made',
                  'decided'      => 'Decided to move, planning the trip',
                  'in-country'   => 'Already in Paraguay',
                  'has-residency'=> 'Already have residency, need tax or banking help',
                  'other'        => 'Something else',
              ];
              foreach ($stages as $k => $label): ?>
                <option value="<?= e($k) ?>"<?= raw_html(($old['stage'] ?? '') === $k && $k !== '' ? ' selected' : '') ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form__row">
          <label class="form__label" for="f-message">Your situation <span class="form__req">required</span></label>
          <textarea class="form__input form__textarea<?= e($err('message') ? ' is-error' : '') ?>" id="f-message"
                    name="message" rows="7" required <?= raw_html($enabled ? '' : 'disabled') ?>
                    <?= raw_html($err('message') ? 'aria-describedby="e-message" aria-invalid="true"' : '') ?>><?= e($val('message')) ?></textarea>
          <?php if ($err('message')): ?><p class="form__err" id="e-message"><?= e($err('message')) ?></p><?php endif; ?>
          <p class="form__hint">Nationality, family situation, rough timing, and anything you think might be a
            complication. Awkward facts are the useful ones — prior refusals, records, unfinished divorces.</p>
        </div>

        <div class="form__foot">
          <button class="btn btn--primary" type="submit" <?= raw_html($enabled ? '' : 'disabled') ?>
                  data-ev="enquiry_submit" data-ev-loc="book">Send this to us</button>
          <p class="form__privacy">We use what you send here to answer you and nothing else. It is not added
            to a marketing list and not passed to anyone outside the work you ask us to do —
            <a href="<?= e(href(page_url('privacy'))) ?>">how we handle your data</a>.</p>
        </div>
      </form>
    </div>
  </div>
</section>
