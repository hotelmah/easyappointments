<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="customers-page" class="container-fluid backend-page">
    <!-- Dedicated toolbar section at the top -->
    <div id="customers-toolbar" class="row">
            <!-- Left side: Search/Filter -->
            <div id="customers-filter" class="col-md-5">
                <form id="filter-customers-form">
                    <div class="input-group">
                        <input type="text" class="key form-control border border-primary" aria-label="keyword" placeholder="<?= lang('search_customers_placeholder') ?>" data-tippy-content="<?= lang('search_customers_hint') ?>" autocomplete="off">
                        <div class="btn-group">
                            <button class="filter btn btn-light" type="submit" data-tippy-content="<?= lang('filter') ?>">
                                <i class="fas fa-search"></i>
                                <?= lang('search') ?>
                            </button>
                            <button id="clear-customers" class="btn btn-light" type="button" data-tippy-content="<?= lang('clear') ?>">
                                <i class="fas fa-times"></i>
                                <?= lang('clear') ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right side: Action buttons -->
            <div id="customers-actions" class="col-md-7">
                <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                    <div id="add-edit-delete-group">
                        <?php if (can('add', PRIV_CUSTOMERS) && (!setting('limit_customer_access') || vars('role_slug') === DB_SLUG_ADMIN)) : ?>
                            <button id="add-customer" class="btn btn-light" data-tippy-content="<?= lang('add_customer_hint') ?>">
                                <i class="fas fa-plus-square me-2"></i>
                                <?= lang('add') ?>
                            </button>
                        <?php endif; ?>

                        <?php if (can('edit', PRIV_CUSTOMERS)) : ?>
                            <button id="edit-customer" class="btn btn-light" data-tippy-content="<?= lang('edit_customer_hint') ?>" disabled>
                                <i class="fas fa-edit me-2"></i>
                                <?= lang('edit') ?>
                            </button>
                        <?php endif; ?>

                        <?php if (can('delete', PRIV_CUSTOMERS)) : ?>
                            <button id="delete-customer" class="btn btn-light" data-tippy-content="<?= lang('delete_customer_hint') ?>" disabled>
                                <i class="fas fa-trash-alt me-2"></i>
                                <?= lang('delete') ?>
                            </button>
                        <?php endif; ?>
                    </div>

                    <div id="save-cancel-group" style="display:none;">
                        <button id="save-customer" class="btn btn-success">
                            <i class="fas fa-check-square me-2"></i>
                            <?= lang('save') ?>
                        </button>
                        <button id="cancel-customer" class="btn btn-light">
                            <i class="fas fa-times-circle me-2"></i>
                            <?= lang('cancel') ?>
                        </button>
                    </div>
                </div>
                <?php slot('after_page_actions'); ?>
            </div>
    </div>

    <div id="customers" class="row g-4">
        <div class="col-12 col-md-5 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('customers') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="customers-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-7 field-col">
            <div class="record-details row">
                <input id="customer-id" type="hidden">

                <div class="col-12 col-md-6 field-col">
                    <h4 class="text-black-50 mb-3">
                        <?= lang('details') ?>
                    </h4>

                    <div id="form-message" class="alert" style="display:none;"></div>

                    <div class="mb-4">
                        <label for="first-name" class="form-label mb-2">
                            <?= lang('first_name') ?>
                            <?php if (vars('require_first_name')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="first-name" class="<?= vars('require_first_name') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="100" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="last-name" class="form-label mb-2">
                            <?= lang('last_name') ?>
                            <?php if (vars('require_last_name')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="last-name" class="<?= vars('require_last_name') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="120" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label mb-2">
                            <?= lang('email') ?>
                            <?php if (vars('require_email')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="email" class="<?= vars('require_email') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="120" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="mobile-phone-number" class="form-label mb-2">
                            <?= lang('mobile_phone_number') ?>
                            <?php if (vars('require_mobile_number')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="mobile-phone-number" maxlength="60" class="<?= vars('require_mobile_number') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="work-phone-number" class="form-label mb-2">
                            <?= lang('work_phone_number') ?>
                            <?php if (vars('require_work_number')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="work-phone-number" maxlength="60" class="<?= vars('require_work_number') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label mb-2">
                            <?= lang('address') ?>
                            <?php if (vars('require_address')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="address" class="<?= vars('require_address') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="120" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="city" class="form-label mb-2">
                            <?= lang('city') ?>
                            <?php if (vars('require_city')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="city" class="<?= vars('require_city') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="120" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="state" class="form-label mb-2">
                            <?= lang('state') ?>
                            <?php if (vars('require_state')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="state" class="<?= vars('require_state') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="120" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="zip-code" class="form-label mb-2">
                            <?= lang('zip_code') ?>
                            <?php if (vars('require_zip_code')) : ?>
                                <span class="text-danger" hidden>*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="zip-code" class="<?= vars('require_zip_code') ? 'required' : '' ?> form-control border border-primary ps-2 disabled" maxlength="120" disabled/>
                    </div>

                    <div class="mb-4">
                        <label class="form-label mb-2" for="language">
                            <?= lang('language') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <select id="language" class="form-select border border-primary required ps-2 disabled" disabled>
                            <?php foreach (vars('available_languages') as $available_language) : ?>
                                <option value="<?= $available_language ?>">
                                    <?= ucfirst($available_language) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label mb-2" for="timezone">
                            <?= lang('timezone') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <?php component('timezone_dropdown', ['attributes' => 'id="timezone" class="form-control border border-primary required ps-2 disabled" disabled',
                            'grouped_timezones' => vars('grouped_timezones')
                        ]); ?>
                    </div>

                    <?php if (setting('ldap_is_active')) : ?>
                        <div class="mb-4">
                            <label for="ldap-dn" class="form-label mb-2">
                                <?= lang('ldap_dn') ?>
                            </label>
                            <input type="text" id="ldap-dn" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled/>
                        </div>
                    <?php endif; ?>

                    <?php component('custom_fields', ['disabled' => true]); ?>

                    <div class="mb-4">
                        <label class="form-label mb-2" for="notes">
                            <?= lang('notes') ?>
                        </label>
                        <textarea id="notes" rows="4" class="form-control border border-primary ps-2 disabled" disabled></textarea>
                    </div>

                    <?php slot('after_primary_fields'); ?>
                </div>

                <div class="col-12 col-md-6 field-col">
                    <h4 class="text-black-50 mb-3">
                        <?= lang('appointments') ?>
                    </h4>

                    <div id="customer-appointments" class="card bg-white border-dark"></div>

                    <?php slot('after_secondary_fields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/customers_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/pages/customers.js') ?>"></script>

<?php end_section('scripts'); ?>
