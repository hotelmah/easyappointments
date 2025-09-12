<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="booking-settings-page" class="container backend-page">
    <div id="booking-settings">
        <div class="row">
            <div class="col-sm-3 offset-sm-1">
                <?php component('settings_nav'); ?>
            </div>
            <div class="col-sm-6">
                <form>
                    <fieldset>
                        <div class="settings-header border-bottom mb-3 py-3">
                            <h3 class="text-black-50 mb-0">
                                <?= lang('booking_settings') ?>
                            </h3>

                            <?php if (can('edit', PRIV_SYSTEM_SETTINGS)) : ?>
                                <button id="save-settings" type="button" class="btn btn-primary">
                                    <i class="fas fa-check-square me-2"></i>
                                    <?= lang('save') ?>
                                </button>
                            <?php endif; ?>
                        </div>

                        <h4 class="text-black-50 border-bottom mb-3 py-3">
                            <?= lang('fields') ?>
                        </h4>

                        <div class="row mb-5 fields-row">
                            <div class="col-lg-6">
                                <div class="form-group mb-5">
                                    <label for="first-name" class="form-label mb-2">
                                        <?= lang('first_name') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="first-name" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-first-name" type="checkbox" data-field="display_first_name" class="form-check-input display-switch">
                                            <label for="display-first-name" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-first-name" type="checkbox" data-field="require_first_name" class="form-check-input require-switch">
                                            <label for="require-first-name" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="last-name" class="form-label mb-2">
                                        <?= lang('last_name') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="last-name" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-last-name" type="checkbox" data-field="display_last_name" class="form-check-input display-switch">
                                            <label for="display-last-name" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input id="require-last-name" type="checkbox" data-field="require_last_name" class="form-check-input require-switch">
                                            <label for="require-last-name" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="email" class="form-label mb-2">
                                        <?= lang('email') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="email" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-email" type="checkbox" data-field="display_email" class="form-check-input display-switch">
                                            <label for="display-email" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input id="require-email" type="checkbox" data-field="require_email" class="form-check-input require-switch">
                                            <label for="require-email" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="mobile-phone-number" class="form-label mb-2">
                                        <?= lang('mobile_phone_number') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="mobile-phone-number" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-phone-number" type="checkbox" data-field="display_mobile_number" class="form-check-input display-switch">
                                            <label for="display-phone-number" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-phone-number" type="checkbox" data-field="require_mobile_number" class="form-check-input require-switch">
                                            <label for="require-phone-number" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="work-phone-number" class="form-label mb-2">
                                        <?= lang('work_phone_number') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="work-phone-number" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-work-number" type="checkbox" data-field="display_work_number" class="form-check-input display-switch">
                                            <label for="display-work-number" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-work-number" type="checkbox" data-field="require_work_number" class="form-check-input require-switch">
                                            <label for="require-work-number" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-5">
                                    <label for="address" class="form-label mt-2 mb-2">
                                        <?= lang('address') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="address" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-address" type="checkbox" data-field="display_address" class="form-check-input display-switch">
                                            <label for="display-address" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-address" type="checkbox" data-field="require_address" class="form-check-input require-switch">
                                            <label for="require-address" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="city" class="form-label mb-2">
                                        <?= lang('city') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="city" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-city" type="checkbox" data-field="display_city" class="form-check-input display-switch">
                                            <label for="display-city" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-city" type="checkbox" data-field="require_city" class="form-check-input require-switch">
                                            <label for="require-city" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="state" class="form-label mb-2">
                                        <?= lang('state') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="state" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-state" type="checkbox" data-field="display_state" class="form-check-input display-switch">
                                            <label for="display-state" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-state" type="checkbox" data-field="require_state" class="form-check-input require-switch">
                                            <label for="require-state" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="zip-code" class="form-label mb-2">
                                        <?= lang('zip_code') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="zip-code" type="text" class="form-control mb-2" readonly>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-zip-code" type="checkbox" data-field="display_zip_code" class="form-check-input display-switch">
                                            <label for="display-zip-code" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-zip-code" type="checkbox" data-field="require_zip_code" class="form-check-input require-switch">
                                            <label for="require-zip-code" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-5">
                                    <label for="notes" class="form-label mb-2">
                                        <?= lang('notes') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea id="notes" class="form-control mb-2" rows="1" readonly></textarea>
                                    <div class="d-flex">
                                        <div class="form-check form-switch me-4">
                                            <input id="display-notes" type="checkbox" data-field="display_notes" class="form-check-input display-switch">
                                            <label for="display-notes" class="form-check-label">
                                                <?= lang('display') ?>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input id="require-notes" type="checkbox" data-field="require_notes" class="form-check-input require-switch">
                                            <label for="require-notes" class="form-check-label">
                                                <?= lang('require') ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-black-50 border-bottom mb-3 py-3">
                            <?= lang('custom_fields') ?>
                        </h4>

                        <div class="row mb-5 fields-row">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <div class="col-sm-6">
                                    <div class="form-group mb-5">
                                        <label for="custom-field-<?= $i ?>" class="form-label mb-2">
                                            <?= lang('custom_field') ?> #<?= $i ?>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="custom-field-<?= $i ?>" type="text" class="form-control mb-2" placeholder="<?= lang('label') ?>" data-field="label_custom_field_<?= $i ?>" aria-label="label">
                                        <div class="d-flex">
                                            <div class="form-check form-switch me-4">
                                                <input id="display-custom-field-<?= $i ?>" type="checkbox" data-field="display_custom_field_<?= $i ?>" class="form-check-input display-switch">
                                                <label for="display-custom-field-<?= $i ?>" class="form-check-label">
                                                    <?= lang('display') ?>
                                                </label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input id="require-custom-field-<?= $i ?>" type="checkbox" data-field="require_custom_field_<?= $i ?>" class="form-check-input require-switch">
                                                <label for="require-custom-field-<?= $i ?>" class="form-check-label">
                                                    <?= lang('require') ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>


                        <h4 class="text-black-50 border-bottom mb-3 py-3">
                            <?= lang('options') ?>
                        </h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="customer-notifications" type="checkbox" data-field="customer_notifications" class="form-check-input">
                                        <label for="customer-notifications" class="form-check-label">
                                            <?= lang('customer_notifications') ?>
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('customer_notifications_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="limit-customer-access" type="checkbox" data-field="limit_customer_access" class="form-check-input">
                                        <label for="limit-customer-access" class="form-check-label">
                                            <?= lang('limit_customer_access') ?>
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('limit_customer_access_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="require-captcha" type="checkbox" data-field="require_captcha" class="form-check-input">
                                        <label for="require-captcha" class="form-check-label">
                                            CAPTCHA
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('require_captcha_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="display-any-provider" type="checkbox" data-field="display_any_provider" class="form-check-input">
                                        <label for="display-any-provider" class="form-check-label">
                                            <?= lang('any_provider') ?>
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('display_any_provider_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="display-login-button" type="checkbox" data-field="display_login_button" class="form-check-input">
                                        <label for="display-login-button" class="form-check-label">
                                            <?= lang('login_button') ?>
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('display_login_button_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="display-delete-personal-information" type="checkbox" data-field="display_delete_personal_information" class="form-check-input">
                                        <label for="display-delete-personal-information" class="form-check-label">
                                            <?= lang('delete_personal_information') ?>
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('delete_personal_information_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="border rounded mb-4 p-3">
                                    <div class="form-check form-switch">
                                        <input id="disable-booking" type="checkbox" data-field="disable_booking" class="form-check-input">
                                        <label for="disable-booking" class="form-check-label">
                                            <?= lang('disable_booking') ?>
                                        </label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('disable_booking_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-4 p-3" hidden>
                                    <label for="disable-booking-message" class="form-label mb-2">
                                        <?= lang('display_message') ?>
                                    </label>
                                    <textarea id="disable-booking-message" cols="30" rows="10"  class="border border-primary mb-3"></textarea>
                                </div>
                            </div>
                        </div>
                        <?php slot('after_primary_fields'); ?>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/booking_settings_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/booking_settings.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
