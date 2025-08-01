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

    <title><?= vars('page_title') ?> | <?= vars('company_name') ?></title>

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . setting('theme', 'default') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/booking_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => vars('company_color')]); ?>

    <?php slot('styles'); ?>
</head>
<body class="d-flex flex-column min-vh-99">
    <header class="booking-header-bar mb-4">
        <div class="container">
            <h1><?= vars('page_title') ?></h1>
        </div>
    </header>

    <main id="main" class="container d-flex align-items-center justify-content-center min-vh-70">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-8 col-lg-6">
                <div id="message-frame" class="text-center">
                    <?php slot('content'); ?>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="mt-auto bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-2">
                📧 Need help? Please visit our
                <a href="<?= e(vars('company_link')) ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none" style="color: <?= vars('company_color') ?? '#429a82' ?>;">
                    website
                </a>
                or contact us via
                <a href="mailto:<?= e(vars('company_email')) ?>?subject=<?= urlencode(vars('page_title')) ?>" class="text-decoration-none" style="color: <?= vars('company_color') ?? '#429a82' ?>;">
                    email.
                </a>
                <?php if (vars('company_phone')) : ?>
                    or call us at
                    <a href="tel:<?= e(vars('company_phone')) ?>" class="text-decoration-none" style="color: <?= vars('company_color') ?? '#429a82' ?>;">
                        <?= e(vars('company_phone')) ?>
                    </a>
                <?php endif; ?>
            </p>
            <div class="border-top pt-3 mt-3">
                <p class="mb-0">
                    &copy; <?= date('Y') ?> <?= vars('company_name') ?>. <?= lang('all_rights_reserved') ?>
                </p>
            </div>
        </div>
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