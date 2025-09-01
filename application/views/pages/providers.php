<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="providers-page" class="container-fluid backend-page">
    <div id="providers-toolbar" class="row">
        <div id="providers-filter" class="col-md-5">
            <form id="filter-providers-form">
                <div class="input-group">
                    <input type="text" class="key form-control border border-primary" aria-label="keyword" placeholder="<?= lang('search_providers_placeholder') ?>" data-tippy-content="<?= lang('search_providers_hint') ?>" autocomplete="off">
                    <div class="btn-group">
                        <button type="submit" class="filter btn btn-light" data-tippy-content="<?= lang('filter') ?>">
                            <i class="fas fa-search"></i>
                            <?= lang('search') ?>
                        </button>
                        <button id="clear-providers" type="button" class="btn btn-light" data-tippy-content="<?= lang('clear') ?>">
                            <i class="fas fa-times"></i>
                            <?= lang('clear') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="provider-actions" class="col-md-7">
            <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                <div class="btn-group" role="tablist" aria-label="<?= lang('view_toggle') ?>">
                    <button id="details-toggle-btn" type="button" role="tab" class="btn btn-outline-primary active" data-bs-toggle="tab" data-bs-target="#details" aria-controls="details" aria-selected="true" data-tippy-content="<?= lang('provider_details_toggle') ?>">
                        <i class="fas fa-info-circle me-1"></i>
                        <?= lang('details') ?>
                    </button>

                    <button id="working-plan-toggle-btn" type="button" role="tab" class="btn btn-outline-primary" data-bs-toggle="tab" data-bs-target="#working-plan" aria-controls="working-plan" aria-selected="false" data-tippy-content="<?= lang('provider_working_plan_toggle') ?>">
                        <i class="fas fa-calendar-alt me-1"></i>
                        <?= lang('working_plan') ?>
                    </button>
                </div>

                <div id="add-edit-delete-group">
                    <button id="add-provider" class="btn btn-light" data-tippy-content="<?= lang('add_provider_hint') ?>">
                        <i class="fas fa-plus-square me-2"></i>
                        <?= lang('add') ?>
                    </button>

                    <button id="edit-provider" class="btn btn-light" data-tippy-content="<?= lang('edit_provider_hint') ?>" disabled>
                        <i class="fas fa-edit me-2"></i>
                        <?= lang('edit') ?>
                    </button>

                    <button id="delete-provider" class="btn btn-light" data-tippy-content="<?= lang('delete_provider_hint') ?>" disabled>
                        <i class="fas fa-trash-alt me-2"></i>
                        <?= lang('delete') ?>
                    </button>
                </div>

                <div id="save-cancel-group" style="display:none;">
                    <button id="save-provider" class="btn btn-success" data-tippy-content="<?= lang('save') ?>">
                        <i class="fas fa-check-square me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    <button id="cancel-provider" class="btn btn-light" data-tippy-content="<?= lang('cancel') ?>">
                        <i class="fas fa-times-circle me-2"></i>
                        <?= lang('cancel') ?>
                    </button>
                </div>
            </div>
            <?php slot('after_page_actions'); ?>
        </div>
    </div>

    <div id="providers" class="row g-4">
        <div class="col-12 col-md-4 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('providers') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="providers-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="record-details column col-12 col-md-7">
            <?php
                // This form message is outside the details view, so that it can be
                // visible when the user has working plan view active.
            ?>
            <div class="form-message alert" style="display:none;"></div>

            <div class="tab-content">
                <div id="details" role="tabpanel" class="details-view tab-pane fade show active clearfix field-col" aria-labelledby="tab-details">
                    <h4 class="text-black-50 mb-3">
                        <?= lang('details') ?>
                    </h4>

                    <input id="provider-id" type="hidden" class="record-id">

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
                                    <input id="is-private" class="form-check-input border border-primary ps-2" type="checkbox">
                                    <label class="form-check-label" for="is-private">
                                        <?= lang('hide_from_public') ?>
                                    </label>
                                </div>

                                <div class="form-text text-muted mb-3">
                                    <small>
                                        <?= lang('private_hint') ?>
                                    </small>
                                </div>

                                <div class="form-check form-switch">
                                    <input id="notifications" type="checkbox" class="form-check-input border border-primary ps-2">
                                    <label for="notifications" class="form-check-label">
                                        <?= lang('receive_notifications') ?>
                                    </label>
                                </div>

                                <div class="form-text text-muted mb-3">
                                    <small>
                                        <?= lang('provider_notifications_hint') ?>
                                    </small>
                                </div>
                            </div>

                            <div>
                                <label class="form-label mb-3">
                                    <?= lang('services') ?>
                                </label>
                            </div>

                            <div id="provider-services" class="card card-body border border-primary rounded mb-3 p-3">
                                <!-- JS -->
                            </div>

                            <?php slot('after_secondary_fields'); ?>
                        </div>
                    </div>
                </div>

                <div id="working-plan" role="tabpanel" class="working-plan-view tab-pane fade clearfix field-col" aria-labelledby="tab-working-plan">
                    <h4 class="text-black-50 mb-3">
                        <?= lang('working_plan') ?>
                    </h4>

                    <p>
                        <?= lang('provider_weekly_working_plan') ?>
                    </p>

                    <div>
                        <button id="reset-working-plan" class="btn btn-primary me-2" data-tippy-content="<?= lang('reset_working_plan') ?>">
                            <i class="fas fa-undo-alt me-2"></i>
                            <?= lang('reset_plan') ?>
                        </button>
                    </div>

                    <br>

                    <table class="working-plan table table-striped table-hover mt-2">
                        <thead class="table-dark">
                        <tr>
                            <th><?= lang('day') ?></th>
                            <th><?= lang('start') ?></th>
                            <th><?= lang('end') ?></th>
                        </tr>
                        </thead>
                        <tbody><!-- Dynamic Content --></tbody>
                    </table>

                    <?php slot('after_working_plan'); ?>

                    <br>

                    <h4 class="text-black-50 mb-3">
                        <?= lang('breaks') ?>
                    </h4>

                    <p>
                        <?= lang('add_breaks_during_each_day') ?>
                    </p>

                    <div>
                        <button type="button" class="add-break btn btn-primary me-2" data-tippy-content="<?= lang('add_break') ?>">
                            <i class="fas fa-plus-square me-2"></i>
                            <?= lang('add_break') ?>
                        </button>
                    </div>

                    <br>

                    <table class="breaks table table-striped mt-2">
                        <thead class="table-dark">
                        <tr>
                            <th><?= lang('day') ?></th>
                            <th><?= lang('start') ?></th>
                            <th><?= lang('end') ?></th>
                            <th><?= lang('actions') ?></th>
                        </tr>
                        </thead>
                        <tbody><!-- Dynamic Content --></tbody>
                    </table>

                    <?php slot('after_breaks'); ?>

                    <br>

                    <h4 class="text-black-50 mb-3">
                        <?= lang('working_plan_exceptions') ?>
                    </h4>

                    <p>
                        <?= lang('add_working_plan_exceptions_during_each_day') ?>
                    </p>

                    <div>
                        <button type="button" class="add-working-plan-exception btn btn-primary me-2" data-tippy-content="<?= lang('add_working_plan_exception') ?>">
                            <i class="fas fa-plus-square me-2"></i>
                            <?= lang('add_working_plan_exception') ?>
                        </button>
                    </div>

                    <br>

                    <table class="working-plan-exceptions table table-striped table-hover mt-2">
                        <thead class="table-dark">
                        <tr>
                            <th><?= lang('day') ?></th>
                            <th><?= lang('start') ?></th>
                            <th><?= lang('end') ?></th>
                            <th><?= lang('actions') ?></th>
                        </tr>
                        </thead>
                        <tbody><!-- Dynamic Content --></tbody>
                    </table>

                    <?php component('working_plan_exceptions_modal'); ?>

                    <?php slot('after_working_plan_exceptions'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/jquery-jeditable@2.0.19/dist/jquery.jeditable.min.js" type="text/javascript"></script>

<script src="<?= asset_url('assets/js/utils/working_plan.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/account_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/providers_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/providers.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
