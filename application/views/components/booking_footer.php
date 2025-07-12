<?php
/**
 * Local variables.
 *
 * @var bool $display_login_button
 */
?>

<footer>
    <button id="select-language" class="btn btn-outline-primary">
        <i class="fas fa-language me-2"></i>
        <?= ucfirst(config('language')) ?>
    </button>

    <?php if ($display_login_button) : ?>
    <button class="btn btn-outline-primary py-1" onclick="window.location.href='<?= session('user_id') ? site_url('calendar') : site_url('login'); ?>'">
        <i class="fas fa-sign-in-alt fa-sm"></i>&nbsp;
        <?= session('user_id') ? lang('backend_section') : lang('login'); ?>
    </button>
    <?php endif; ?>
</footer>