<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="secretaries-page" class="container-fluid backend-page">
    <div id="secretaries-toolbar" class="row">
        <div id="secretaries-filter" class="col-md-5">
            <form id="filter-secretaries-form">
                <div class="input-group">
                    <input type="text" class="key form-control border border-primary" aria-label="keyword" placeholder="<?= lang('search_secretaries_placeholder') ?>" data-tippy-content="<?= lang('search_secretaries_hint') ?>" autocomplete="off">
                    <div class="btn-group">
                        <button type="submit" class="filter btn btn-light" data-tippy-content="<?= lang('filter') ?>">
                            <i class="fas fa-search"></i>
                            <?= lang('search') ?>
                        </button>
                        <button id="clear-secretaries" type="button" class="btn btn-light" data-tippy-content="<?= lang('clear') ?>">
                            <i class="fas fa-times"></i>
                            <?= lang('clear') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="secretary-actions" class="col-md-7">
            <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                <div id="add-edit-delete-group">
                    <button id="add-secretary" class="btn btn-light" data-tippy-content="<?= lang('add_secretary_hint') ?>">
                        <i class="fas fa-plus-square me-2"></i>
                        <?= lang('add') ?>
                    </button>

                    <button id="edit-secretary" class="btn btn-light" data-tippy-content="<?= lang('edit_secretary_hint') ?>" disabled>
                        <i class="fas fa-edit me-2"></i>
                        <?= lang('edit') ?>
                    </button>

                    <button id="delete-secretary" class="btn btn-light" data-tippy-content="<?= lang('delete_secretary_hint') ?>" disabled>
                        <i class="fas fa-trash-alt me-2"></i>
                        <?= lang('delete') ?>
                    </button>
                </div>

                <div id="save-cancel-group" style="display:none;">
                    <button id="save-secretary" class="btn btn-success" data-tippy-content="<?= lang('save') ?>">
                        <i class="fas fa-check-square me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    <button id="cancel-secretary" class="btn btn-light" data-tippy-content="<?= lang('cancel') ?>">
                        <i class="fas fa-times-circle me-2"></i>
                        <?= lang('cancel') ?>
                    </button>
                </div>
            </div>
            <?php slot('after_page_actions'); ?>
        </div>
    </div>

    <div id="secretaries" class="row g-4">
        <div class="col-12 col-md-4 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('secretaries') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="secretaries-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="record-details column col-12 col-md-7 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('details') ?>
            </h4>

            <div class="form-message alert" style="display:none;"></div>

            <input id="secretary-id" type="hidden" class="record-id">

            <div class="row">
                <div class="details col-12 col-md-6">
                    <div class="mb-4">
                        <label for="first-name" class="form-label mb-2">
                            <?= lang('first_name') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="first-name" type="text" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="last-name" class="form-label mb-2">
                            <?= lang('last_name') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="last-name" type="text" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label mb-2">
                            <?= lang('email') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="email" type="email" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="mobile-phone-number" class="form-label mb-2">
                            <?= lang('mobile_phone_number') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="mobile-phone-number" type="tel" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="work-phone-number" class="form-label mb-2">
                            <?= lang('work_phone_number') ?>
                        </label>
                        <input id="work-phone-number" type="tel" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label mb-2">
                            <?= lang('address') ?>
                        </label>
                        <input id="address" type="text" class="form-control border border-primary ps-2 disabled" maxlength="200" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="city" class="form-label mb-2">
                            <?= lang('city') ?>
                        </label>
                        <input id="city" type="text" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="state" class="form-label mb-2">
                            <?= lang('state') ?>
                        </label>
                        <input id="state" type="text" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="zip-code" class="form-label mb-2">
                            <?= lang('zip_code') ?>
                        </label>
                        <input id="zip-code" type="text" class="form-control border border-primary ps-2 disabled" maxlength="64" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label mb-2">
                            <?= lang('notes') ?>
                        </label>
                        <textarea id="notes" class="form-control border border-primary ps-2 disabled" rows="3" disabled></textarea>
                    </div>

                    <?php slot('after_primary_fields'); ?>
                </div>
                <div class="settings col-12 col-md-6">
                    <div class="mb-4">
                        <label for="username" class="form-label mb-2">
                            <?= lang('username') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="username" type="text" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label mb-2">
                            <?= lang('password') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="password" type="password" class="required form-control border border-primary ps-2 disabled" maxlength="100" autocomplete="new-password" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label mb-2">
                            <?= lang('retype_password') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="password-confirm" type="password" class="required form-control border border-primary ps-2 disabled" maxlength="100" autocomplete="new-password" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="calendar-view" class="form-label mb-2">
                            <?= lang('calendar') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <select id="calendar-view" class="required form-select border border-primary ps-2 disabled" disabled>
                            <option value="default"><?= lang('default') ?></option>
                            <option value="table"><?= lang('table') ?></option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="language" class="form-label mb-2">
                            <?= lang('language') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <select id="language" class="required form-select border border-primary ps-2 disabled" disabled>
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
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <?php component('timezone_dropdown', [
                            'attributes' => 'id="timezone" class="required form-select border border-primary ps-2 disabled" disabled',
                            'grouped_timezones' => vars('grouped_timezones'),
                        ]); ?>
                    </div>

                    <?php if (setting('ldap_is_active')) : ?>
                        <div class="mb-4">
                            <label for="ldap-dn" class="form-label mb-2">
                                <?= lang('ldap_dn') ?>
                            </label>
                            <input id="ldap-dn" type="text" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled/>
                        </div>
                    <?php endif; ?>

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

                    <div>
                        <label class="form-label mb-3">
                            <?= lang('providers') ?>
                        </label>
                    </div>

                    <div id="secretary-providers" class="card card-body border border-primary rounded mb-3 p-3">
                        <!-- JS -->
                    </div>

                    <?php slot('after_secondary_fields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/account_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/secretaries_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/secretaries.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
