<!doctype html>
<html lang="<?= config('language_code') ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#35A768">
    <meta name="google" content="notranslate">

    <meta name="description" content="<?= vars('page_title') ?> | <?= vars('company_name') ?>">
    <meta name="keywords" content="<?= vars('page_title') ?>, <?= vars('company_name') ?>, EasyAppointments, booking, appointment, scheduling">
    <meta name="author" content="Kevin Pereira">
    <meta name="robots" content="index, follow">

    <?php slot('meta'); ?>

    <title><?= vars('page_title') ?? lang('account') ?> | <?= vars('company_name') ?></title>

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . setting('theme', 'default') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/account_layout.css') ?>">

    <?php slot('styles'); ?>
</head>
<body>
    <div id="login-frame" class="d-flex flex-column justify-content-between vh-70 bg-light">

        <?php slot('content'); ?>

        <div class="fixed-bottom bg-light text-dark text-center py-4">
            &copy; <?= date('Y') ?> <?= vars('company_name') ?> <?= lang('appointments') ?>. <?= lang('all_rights_reserved') ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" type="text/javascript"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.6.0/builds/moment-timezone-with-data.min.js" type="text/javascript"></script>

    <script src="<?= asset_url('assets/js/app.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/date.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/file.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/http.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/lang.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/message.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/string.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/url.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/utils/validation.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/layouts/account_layout.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/http/account_http_client.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>" type="text/javascript"></script>

    <?php component('js_vars_script'); ?>
    <?php component('js_lang_script'); ?>

    <?php slot('scripts'); ?>
</body>
</html>
