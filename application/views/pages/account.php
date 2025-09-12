<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="account-page" class="container backend-page">
    <div id="account">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form>
                    <fieldset>
                        <div class="settings-header border-bottom mb-3 py-3">
                            <h3 class="text-black-50 mb-0">
                                <?= lang('account') ?>
                            </h3>

                            <?php if (can('edit', PRIV_USER_SETTINGS)) : ?>
                                <button id="save-settings" type="button" class="btn btn-primary">
                                    <i class="fas fa-check-square me-2"></i>
                                    <?= lang('save') ?>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="form-message alert" style="display:none;"></div>

                        <div class="row">
                            <div class="col-lg-6">
                                <input id="user-id" type="hidden">

                                <div class="mb-4">
                                    <label for="first-name" class="form-label mb-2">
                                        <?= lang('first_name') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="first-name" type="text" class="required form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="last-name" class="form-label mb-2">
                                        <?= lang('last_name') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="last-name" type="text" class="required form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label mb-2">
                                        <?= lang('email') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="email" type="email" class="required form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="mobile-phone-number" class="form-label mb-2">
                                        <?= lang('mobile_phone_number') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="mobile-phone-number" type="tel" class="required form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="work-phone-number" class="form-label mb-2">
                                        <?= lang('work_phone_number') ?>
                                    </label>
                                    <input id="work-phone-number" type="tel" class="form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="address" class="form-label mb-2">
                                        <?= lang('address') ?>
                                    </label>
                                    <input id="address" type="text" class="form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="city" class="form-label mb-2">
                                        <?= lang('city') ?>
                                    </label>
                                    <input id="city" type="text" class="form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="state" class="form-label mb-2">
                                        <?= lang('state') ?>
                                    </label>
                                    <input id="state" type="text" class="form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="zip-code" class="form-label mb-2">
                                        <?= lang('zip_code') ?>
                                    </label>
                                    <input id="zip-code" type="text" class="form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="notes" class="form-label mb-2">
                                        <?= lang('notes') ?>
                                    </label>
                                    <textarea id="notes" class="form-control border border-primary ps-2" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="username" class="form-label mb-2">
                                        <?= lang('username') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="username" type="text" class="required form-control border border-primary ps-2" maxlength="100">
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label mb-2">
                                        <?= lang('password') ?>
                                    </label>
                                    <input id="password" type="password" class="form-control border border-primary ps-2" maxlength="100" autocomplete="new-password">
                                </div>

                                <div class="mb-4">
                                    <label for="retype-password" class="form-label mb-2">
                                        <?= lang('retype_password') ?>
                                    </label>
                                    <input id="retype-password" type="password" class="form-control border border-primary ps-2" maxlength="100" autocomplete="new-password">
                                </div>

                                <div class="mb-4">
                                    <label for="calendar-view" class="form-label mb-2">
                                        <?= lang('calendar') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="calendar-view" class="required form-select border border-primary ps-2">
                                        <option value="default"><?= lang('default') ?></option>
                                        <option value="table"><?= lang('table') ?></option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="language" class="form-label mb-2">
                                        <?= lang('language') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="language" class="required form-select border border-primary ps-2">
                                        <?php foreach (vars('available_languages') as $available_language) : ?>
                                            <option value="<?= $available_language ?>">
                                                <?= ucfirst($available_language) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="timezone" class="form-label mb-2">
                                        <?= lang('timezone') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <?php component('timezone_dropdown', [
                                        'attributes' => 'id="timezone" class="required form-select border border-primary ps-2"',
                                        'grouped_timezones' => vars('grouped_timezones'),
                                    ]); ?>
                                </div>

                                <div>
                                    <label class="form-label mb-3">
                                        <?= lang('options') ?>
                                    </label>
                                </div>

                                <div class="border border-primary rounded mb-3 p-3">
                                    <div class="form-check form-switch">
                                        <input id="notifications" type="checkbox" class="form-check-input border border-primary ps-2">
                                        <label for="notifications" class="form-check-label">
                                            <?= lang('receive_notifications') ?>
                                        </label>
                                    </div>

                                    <div class="form-text text-muted mb-3">
                                        <small>
                                            <?= lang('notifications_hint') ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/utils/validation.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/account_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/account.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
