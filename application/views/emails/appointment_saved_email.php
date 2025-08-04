<?php

/**
 * Local variables.
 *
 * @var string $subject
 * @var string $message
 * @var array $appointment
 * @var array $service
 * @var array $provider
 * @var array $customer
 * @var array $settings
 * @var string $timezone
 * @var string $appointment_link
 */
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            #header {
                max-width: 650px;
                width: 90%;
                height: 65px;
                margin: 0 auto;
                padding: 5px 10px;
                position: relative;
                text-align: center;
                background-color: <?= $settings['company_color'] ?? '#429a82' ?>;
                background: linear-gradient(135deg, <?= $settings['company_color'] ?? '#4ca68e' ?>, #337765);
            }

            #header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 4px;
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
                display: inline-block;
                line-height: 55px;
                color: white;
                font-size: 22px;
                font-weight: 700;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                text-shadow: 0 3px 6px rgba(0,0,0,0.4);
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
                padding: 10px 20px;
                background-color: white;
            }

            h2 {
                margin: 25px 0 15px 0;
                padding-left: 12px;
                padding-top: 6px;
                padding-bottom: 6px;
                color: #2c3e50;
                font-size: 20px;
                font-weight: 600;
                background-color: rgb(241, 235, 240);
                border-left: 4px solid <?= $settings['company_color'] ?? '#429a82' ?>;
            }

            #appointment-details, #customer-details {
                width: 100%;
                margin: 15px 0 25px 0;
                overflow: hidden;
                background-color: lightcyan;
                border-collapse: collapse;
                border-color: <?= $settings['company_color'] ?? '#429a82' ?>;
                border-width: 1px;
                border-style: solid;
                border-radius: 6px;
                box-shadow: 3px 3px 4px rgba(0,0,0,0.1);
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
                max-width: 650px;
                width: 90%;
                margin: 30px auto 0 auto;
                padding: 20px;
                position: relative;
                text-align: center;
                color: #47494b;
                font-size: 14px;
                background-color: rgb(193, 186, 186);
                background: linear-gradient(135deg, #dadbdc, #e7eaec);
                border-top: 1px solid #a2a2a2;
            }

            #footer::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 6px;
                background: rgba(87, 145, 72, 0.3);
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
                <span><?= e($settings['company_name']) ?></span>
                <span><?= lang('appointment') ?>s</span>
            </strong>
        </div>

        <div class="email-container">
            <div id="content">
                <h2><?= $subject ?></h2>

                <p>
                    <?= $message ?>
                </p>

                <h2><?= lang('appointment_details_title') ?></h2>

                <table id="appointment-details">
                    <?php if (!empty($appointment['status'])) : ?>
                    <tr>
                        <td class="label">
                            <?= lang('status') ?>
                        </td>
                        <td>
                            <span style="display: inline-block;
                                        background-color: #28a745;
                                        color: white;
                                        padding: 4px 12px;
                                        border-radius: 12px;
                                        font-size: 12px;
                                        font-weight: 600;">
                                ✓ <?= e($appointment['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('Service', $fieldNames_changed) ?>">
                            <?= lang('service') ?>
                        </td>
                        <td style="<?= getHighlightStyle('Service', $fieldNames_changed) ?>">
                            <?= e($service['name']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('Provider', $fieldNames_changed) ?>">
                            <?= lang('provider') ?>
                        </td>
                        <td style="<?= getHighlightStyle('Provider', $fieldNames_changed) ?>">
                            <?= e($provider['first_name'] . ' ' . $provider['last_name']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('StartDateTime', $fieldNames_changed) ?>">
                            <?= lang('start') ?>
                        </td>
                        <td style="<?= getHighlightStyle('StartDateTime', $fieldNames_changed) ?>">
                            <?= format_date_time($appointment['start_datetime']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('StartDateTime', $fieldNames_changed) ?>">
                            <?= lang('end') ?>
                        </td>
                        <td style="<?= getHighlightStyle('StartDateTime', $fieldNames_changed) ?>">
                            <?= format_date_time($appointment['end_datetime']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <?= lang('duration_minutes') ?>
                        </td>
                        <td>
                            <?= e($service['duration']) ?>

                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <?= lang('price') ?>
                        </td>
                        <td>
                            <?php
                            $currencySymbol = '$';
                            if (!empty($service['currency'])) {
                                // Add more currency symbols as needed
                                switch (strtoupper($service['currency'])) {
                                    case 'USD':
                                        $currencySymbol = '$';
                                        break;
                                    case 'EUR':
                                        $currencySymbol = '€';
                                        break;
                                    case 'GBP':
                                        $currencySymbol = '£';
                                        break;
                                    // ...add more cases if needed...
                                    default:
                                        $currencySymbol = $service['currency'];
                                }
                            }
                            ?>
                            <?= $currencySymbol . number_format((float)$service['price'], 2) ?> &nbsp; <?= e($service['currency']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <?= lang('description') ?>
                        </td>
                        <td>
                            <?= e($service['description']) ?>
                        </td>
                    </tr>

                    <?php if (!empty($appointment['location'])) : ?>
                        <tr>
                            <td class="label">
                                <?= lang('location') ?>
                            </td>
                            <td>
                                <?= e($appointment['location']) ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if (!empty($appointment['notes'])) : ?>
                        <tr>
                            <td class="label" style="<?= getHighlightStyle('Notes', $fieldNames_changed) ?>">
                                <?= lang('notes') ?>
                            </td>
                            <td style="<?= getHighlightStyle('Notes', $fieldNames_changed) ?>">
                                <?= e($appointment['notes']) ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('Timezone', $fieldNames_changed) ?>">
                            <?= lang('timezone') ?>
                        </td>
                        <td style="<?= getHighlightStyle('Timezone', $fieldNames_changed) ?>">
                            <?= format_timezone($timezone) ?>
                        </td>
                    </tr>
                </table>

                <h2><?= lang('customer_details_title') ?></h2>

                <table id="customer-details">
                    <tr>
                        <td class="label" style="<?= getHighlightStyle('FirstName', $fieldNames_changed) || shouldHighlight('LastName', $fieldNames_changed) ? 'color: #dc3545; font-weight: bold;' : '' ?>">
                            <?= lang('name') ?>
                        </td>
                        <td style="<?= getHighlightStyle('FirstName', $fieldNames_changed) || shouldHighlight('LastName', $fieldNames_changed) ? 'color: #dc3545; font-weight: bold;' : '' ?>">
                            <?= e($customer['first_name'] . ' ' . $customer['last_name']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('Email', $fieldNames_changed) ?>">
                            <?= lang('email') ?>
                        </td>
                        <td style="<?= getHighlightStyle('Email', $fieldNames_changed) ?>">
                            <?= e($customer['email']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('MobilePhoneNumber', $fieldNames_changed) ?>">
                            <?= lang('mobile_phone_number') ?>
                        </td>
                        <td style="<?= getHighlightStyle('MobilePhoneNumber', $fieldNames_changed) ?>">
                            <?= e($customer['mobile_phone_number']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('WorkPhoneNumber', $fieldNames_changed) ?>">
                            <?= lang('work_phone_number') ?>
                        </td>
                        <td style="<?= getHighlightStyle('WorkPhoneNumber', $fieldNames_changed) ?>">
                            <?= e($customer['work_phone_number']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label" style="<?= getHighlightStyle('Address', $fieldNames_changed) || shouldHighlight('CityStateZip', $fieldNames_changed) ? 'color: #dc3545; font-weight: bold;' : '' ?>">
                            <?= lang('address') ?>
                        </td>
                        <td style="<?= getHighlightStyle('Address', $fieldNames_changed) || shouldHighlight('CityStateZip', $fieldNames_changed) ? 'color: #dc3545; font-weight: bold;' : '' ?>">
                            <?= e($customer['address']) . ' ' . e($customer['city']) . ', ' . e($customer['state']) . ' ' . e($customer['zip_code']) ?>
                        </td>
                    </tr>

                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <?php if (setting('display_custom_field_' . $i)) : ?>
                            <tr>
                                <td class="label" style="<?= getHighlightStyle('CustomField' . $i, $fieldNames_changed) ?>">
                                    <?= setting('label_custom_field_' . $i) ?: lang('custom_field') . ' #' . $i ?>
                                </td>
                                <td style="<?= getHighlightStyle('CustomField' . $i, $fieldNames_changed) ?>">
                                    <?= $customer['custom_field_' . $i] ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                </table>

                <h2><?= lang('appointment_link_title') ?></h2>

                <div style="text-align: center; margin: 25px 0;">
                    <a href="<?= e($appointment_link) ?>"
                    style="display: inline-block;
                            background-color: <?= $settings['company_color'] ?? '#429a82' ?>;
                            color: white;
                            padding: 12px 25px;
                            text-decoration: none;
                            border-radius: 5px;
                            font-weight: 600;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                            transition: all 0.3s ease;">
                        📅 Manage Your Appointment
                    </a>
                </div>

                <p style="text-align: center; font-size: 12px; color: #666; margin-top: 10px;">
                    <a href="<?= e($appointment_link) ?>" style="color: #666; text-decoration: underline;">
                        <?= e($appointment_link) ?>
                    </a>
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