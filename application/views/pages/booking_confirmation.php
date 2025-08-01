<?php extend('layouts/message_layout'); ?>

<?php section('content'); ?>
<div class="container text-center">
    <div>
        <img id="success-icon" class="mt-0 mb-4" src="<?= base_url('assets/img/success.png') ?>" alt="success"/>
    </div>

    <div class="mb-0">
        <h4 class="mb-4"><?= lang('appointment_registered') ?></h4>

        <p class="mb-4">
            <?= lang('appointment_details_was_sent_to_you') ?>
            <?= lang('check_spam_folder') ?>
        </p>

        <a href="<?= site_url() ?>" class="btn btn-primary btn-narrow">
            <i class="fas fa-calendar-alt me-2"></i>
            <?= lang('go_to_booking_page') ?>
        </a>

        <a href="<?= vars('add_to_google_url') ?>" id="add-to-google-calendar" class="btn btn-narrow" target="_blank">
            <i class="fas fa-plus me-2"></i>
            <?= lang('add_to_google_calendar') ?>
        </a>
    </div>
</div>
<?php end_section('content'); ?>

<?php section('scripts'); ?>

<?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]); ?>
<?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url'), 'matomo_analytics_site_id' => vars('matomo_analytics_site_id')]); ?>

<?php end_section('scripts'); ?>
