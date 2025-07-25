<?php

/**
 * Local variables.
 *
 * @var string $subject
 * @var string $message
 * @var array $settings
 */
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= $subject ?> | <?= e($settings['company_name']) ?></title>
        <style>
            #header {
                height: 125px;
                padding: 10px 15px;
                position: relative;
                background-color: <?= $settings['company_color'] ?? '#429a82' ?>;
                background: linear-gradient(135deg, <?= $settings['company_color'] ?? '#429a82' ?>, #357a66);
            }

            #header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: rgba(255,255,255,0.3);
            }

            body {
                margin: 0;
                padding: 0;
                color: #333;
                font-size: 14px;
                line-height: 1.6;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background-color: #f8f9fa;
            }

            #logo {
                margin-top: 15px;
                display: inline-block;
                color: white;
                font-size: 24px;
                font-weight: 300;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }

            .label {
                padding: 3px;
                font-weight: bold;
                color: #333;
            }

            .email-container {
                max-width: 650px;
                width: 90%;
                border: 1px solid #eee;
                margin: 30px auto;
            }

            #content {
                min-height: 400px;
                padding: 25px 20px;
                background: white;
            }

            h2 {
                margin: 25px 0 15px 0;
                padding-left: 12px;
                color: #2c3e50;
                font-size: 20px;
                font-weight: 600;
                border-left: 4px solid <?= $settings['company_color'] ?? '#429a82' ?>;
            }

            #appointment-details, #customer-details {
                width: 100%;
                margin: 15px 0 25px 0;
                overflow: hidden;
                background: white;
                border: none;
                border-collapse: collapse;
                border-radius: 6px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            #appointment-details td, #customer-details td {
                padding: 12px 15px;
                border-bottom: 1px solid #eee;
                vertical-align: top;
            }

            #appointment-details .label, #customer-details .label {
                width: 35%;
                font-weight: 600;
                color: #555;
                background-color: #f8f9fa;
                border-right: 1px solid #eee;
            }

            #appointment-details tr:last-child td,
            #customer-details tr:last-child td {
                border-bottom: none;
            }

            #footer {
                margin-top: 30px;
                padding: 20px;
                text-align: center;
                color: #6c757d;
                font-size: 12px;
                background-color:rgb(193, 186, 186);
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                border-top: 1px solid #dee2e6;
            }

            #footer a {
                text-decoration: none;
                color: #429a82;
            }

            #footer a:hover {
                text-decoration: underline;
            }

            a {
                color: #429a82;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }
            /* Responsive styles */
            /* Enhanced mobile compatibility */
            @media (max-width: 600px) {
                .email-container {
                    width: 100% !important;
                    margin: 0 !important;
                    border-radius: 0 !important;
                }

                #content {
                    padding: 15px !important;
                }

                #appointment-details .label,
                #customer-details .label {
                    width: 40% !important;
                    font-size: 12px !important;
                }

                #header {
                    padding: 15px !important;
                    text-align: center;
                }

                #logo {
                    font-size: 18px !important;
                }
            }
        </style>
    </head>

    <body>
        <div id="header">
            <strong id="logo">
                <?= e($settings['company_name']) ?>
                <span>&nbsp; &nbsp;<?= lang('appointment') ?>s</span>
            </strong>
        </div>

        <div class="email-container">
            <div id="content">
                <h2>
                    <?= $subject ?>
                </h2>
                <p>
                    <?= $message ?>
                </p>
            </div>
        </div>

        <div id="footer">
            <div style="margin-bottom: 15px;">
                <strong style="color: <?= $settings['company_color'] ?? '#429a82' ?>;">
                    <?= e($settings['company_name']) ?>
                </strong>
            </div>

            <div style="margin-bottom: 10px;">
                📧 Need help? Reply to this email or visit our
                <a href="<?= e($settings['company_link']) ?>"
                style="color: <?= $settings['company_color'] ?? '#429a82' ?>; text-decoration: none;">
                    website
                </a>
            </div>

            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                &copy; <?= date('Y') ?> <?= e($settings['company_name']) ?>. <?= lang('all_rights_reserved') ?>
            </div>
        </div>
    </body>
</html>