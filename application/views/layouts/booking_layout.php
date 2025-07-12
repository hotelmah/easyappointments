<!doctype html>
<html lang="<?= config('language_code') ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#35A768">
    <meta name="google" content="notranslate">

    <meta property="og:title" content="<?= lang('page_title') . ' ' . vars('company_name') ?> | Easy!Appointments"/>
    <meta property="og:description" content="Book Your Appointment With A Few Clicks"/>
    <meta property="og:url" content="<?= base_url() ?>">
    <meta property="og:image" content="<?= base_url('assets/img/social-card.png') ?>"/>
    <meta property="og:type" content="website">

    <?php slot('meta'); ?>

    <title><?= lang('page_title') . ' ' . vars('company_name') ?> | Easy!Appointments</title>

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3.1.1/build/cookieconsent.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . vars('theme') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/booking_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => vars('company_color')]); ?>

    <?php slot('styles'); ?>
</head>

<body>
    <?php component('booking_header', ['company_name' => vars('company_name'), 'company_logo' => vars('company_logo')]); ?>
    <main class="container">
        <div class="row">
            <div id="book-appointment-wizard" class="col-12 col-lg-10 col-xl-8 col-xxl-7">
                <?php slot('content'); ?>
            </div>
        </div>
    </main>
    <?php component('booking_footer', ['display_login_button' => vars('display_login_button')]); ?>

    <?php if (vars('display_cookie_notice') === '1') : ?>
        <?php component('cookie_notice_modal', ['cookie_notice_content' => vars('cookie_notice_content')]); ?>
    <?php endif; ?>

    <?php if (vars('display_terms_and_conditions') === '1') : ?>
        <?php component('terms_and_conditions_modal', [
            'terms_and_conditions_content' => vars('terms_and_conditions_content'),
        ]); ?>
    <?php endif; ?>

    <?php if (vars('display_privacy_policy') === '1') : ?>
        <?php component('privacy_policy_modal', ['privacy_policy_content' => vars('privacy_policy_content')]); ?>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.6.0/builds/moment-timezone-with-data.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js" type="text/javascript"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3.1.1/build/cookieconsent.min.js" type="text/javascript"></script>

    <script src="<?= asset_url('assets/js/app.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/date.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/file.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/http.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/lang.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/message.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/string.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/ui.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/url.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/validation.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/layouts/booking_layout.js') ?>" type="text/javascript"></script>

    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>" type="text/javascript"></script>

    <?php component('js_vars_script'); ?>
    <?php component('js_lang_script'); ?>

    <?php slot('scripts'); ?>

    <?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]); ?>
    <?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url'), 'matomo_analytics_site_id' => vars('matomo_analytics_site_id'), ]); ?>
</body>
</html>
