<?php extend('layouts/message_layout'); ?>

<?php section('content'); ?>
<div class="container text-center">
    <div>
        <img id="message-icon" class="mt-0 mb-5" src="<?= vars('message_icon') ?>" alt="warning">
    </div>

    <div class="mb-5">
        <h3 class="mb-5"><?= vars('message_header') ?></h3>

        <p><?= vars('message_text') ?></p>
    </div>
</div>
<?php end_section('content'); ?>

<?php section('scripts'); ?>

<?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]); ?>
<?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url'), 'matomo_analytics_site_id' => vars('matomo_analytics_site_id')]); ?>

<?php end_section('scripts'); ?>