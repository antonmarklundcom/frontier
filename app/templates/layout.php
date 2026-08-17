<?php /** @var array $page @var array $crumbs */ ?>
<!DOCTYPE html>
<html lang="en">
<?php partial('partials/head', ['page' => $page, 'crumbs' => $crumbs]); ?>
<body class="page page--<?= e($page['id']) ?>">
<a class="skip-link" href="#main"><?= e(t('skip_to_content')) ?></a>

<?php partial('partials/route-rail', ['page' => $page]); ?>
<?php partial('partials/header', ['page' => $page]); ?>

<main id="main">
    <?php if (($page['url'] ?? '/') !== '/'): ?>
        <?php partial('partials/breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php endif; ?>

    <?php foreach ($page['blocks'] as $block) {
        render_block($block, $page);
    } ?>
</main>

<?php partial('partials/footer', ['page' => $page]); ?>
<script src="<?= e(asset('assets/js/site.js')) ?>" defer></script>
</body>
</html>
