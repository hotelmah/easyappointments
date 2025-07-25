<!doctype html>
<html lang="<?= config('language_code') ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#35A768">
    <meta name="google" content="notranslate">

    <?php slot('meta'); ?>

    <title><?= vars('page_title') . ' ' . vars('company_name') ?></title>

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . setting('theme', 'default') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/booking_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => vars('company_color')]); ?>

    <?php slot('styles'); ?>
</head>
<body>
    <header class="booking-header-bar">
        <h1><?= vars('page_title') . ' ' . vars('company_name') ?></h1>
    </header>

    <main id="main" class="container">
        <div class="row">
            <div id="message-frame" class="col-12 border my-auto frame-container">
                <?php slot('content'); ?>
            </div>
        </div>
    </main>

    <footer class="mt-2">
        <small>
            📧 Need help? Reply to this email or visit our
            <a href="<?= e($settings['company_link']) ?>"
            style="color: <?= $settings['company_color'] ?? '#429a82' ?>; text-decoration: none;">
                website
            </a>
            &copy; <?= date('Y') ?> <?= vars('company_name') ?> <?= lang('all_rights_reserved') ?>
            <br>
            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                &copy; <?= date('Y') ?> <?= e($settings['company_name']) ?>. <?= lang('all_rights_reserved') ?>
            </div>
            <a href="<?= vars('company_url') ?>" target="_blank"><?= vars('company_name') ?></a>
            <br>
            <a href="<?= vars('company_email') ?>"><?= vars('company_email') ?></a>
            <br>
            <a href="<?= vars('company_phone') ?>"><?= vars('company_phone') ?></a>
            <br>
            <small><?= lang('version') ?>: <?= vars('app_version') ?></small>
            <br>
            <small><?= lang('last_updated') ?>: <?= vars('last_updated') ?></small>
        </small>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.6.0/builds/moment-timezone-with-data.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js" type="text/javascript"></script>

    <script src="<?= asset_url('assets/js/app.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/date.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/file.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/http.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/lang.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/message.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/string.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/url.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/validation.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/layouts/message_layout.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>" type="text/javascript"></script>

    <?php component('js_vars_script'); ?>
    <?php component('js_lang_script'); ?>

    <?php slot('scripts'); ?>
</body>
</html>