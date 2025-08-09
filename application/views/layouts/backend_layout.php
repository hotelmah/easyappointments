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

    <title><?= lang('backend_section') ?> | <?= vars('company_name') ?></title>

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.31.0/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . setting('theme', 'default') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/backend_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => setting('company_color')]); ?>

    <?php slot('styles'); ?>
</head>
<body class="d-flex flex-column h-100">
    <?php component('backend_header', ['active_menu' => vars('active_menu')]); ?>
    <main class="flex-shrink-0">
        <?php slot('content'); ?>
    </main>
    <?php component('backend_footer', ['user_display_name' => vars('user_display_name')]); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-jeditable@2.0.19/dist/jquery.jeditable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.6.0/builds/moment-timezone-with-data.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.31.0/dist/trumbowyg.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js" type="text/javascript"></script>

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
    <script src="<?= asset_url('assets/js/layouts/backend_layout.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>" type="text/javascript"></script>

    <?php component('js_vars_script'); ?>
    <?php component('js_lang_script'); ?>

    <?php slot('scripts'); ?>
</body>
</html>
