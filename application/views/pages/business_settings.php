<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="business-logic-page" class="container backend-page">
    <div id="business-logic">
        <div class="row">
            <div class="col-sm-3 offset-sm-1">
                <?php component('settings_nav'); ?>
            </div>
            <div class="col-sm-6">
                <form>
                    <fieldset>
                        <div class="settings-header border-bottom mb-3 py-3">
                            <h3 class="text-black-50 mb-0">
                                <?= lang('business_logic') ?>
                            </h3>

                            <?php if (can('edit', PRIV_SYSTEM_SETTINGS)) : ?>
                                <button id="save-settings" type="button" class="btn btn-primary">
                                    <i class="fas fa-check-square me-2"></i>
                                    <?= lang('save') ?>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12 field-col">
                                <h4 class="text-black-50 mb-4"><?= lang('default_working_plan') ?></h4>

                                <p class="form-text text-muted mb-4">
                                    <?= lang('edit_working_plan_hint') ?>
                                </p>

                                <table class="working-plan table table-striped table-hover border">
                                    <thead class="table-dark">
                                    <tr>
                                        <th><?= lang('day') ?></th>
                                        <th><?= lang('start') ?></th>
                                        <th><?= lang('end') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody><!-- Dynamic Content --></tbody>
                                </table>

                                <div class="text-end mb-5">
                                    <button id="apply-global-working-plan" type="button" class="btn btn-danger">
                                        <i class="fas fa-check"></i>
                                        <?= lang('apply_to_all_providers') ?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 field-col">
                                <h4 class="text-black-50 mb-4"><?= lang('default_breaks') ?></h4>

                                <p class="form-text text-muted">
                                    <?= lang('edit_default_breaks_hint') ?>
                                </p>

                                <div class="mt-2 mb-4">
                                    <button type="button" class="add-break btn btn-primary">
                                        <i class="fas fa-plus-square me-2"></i>
                                        <?= lang('add_break') ?>
                                    </button>
                                </div>

                                <table class="breaks table table-striped table-hover border mb-5">
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
                            </div>
                            <div class="col-12 field-col">
                                <?php if (can('view', PRIV_BLOCKED_PERIODS)) : ?>
                                    <h4 class="text-black-50 mb-4"><?= lang('blocked_periods') ?></h4>

                                    <p class="form-text text-muted">
                                        <?= lang('blocked_periods_hint') ?>
                                    </p>

                                    <div class="mb-5">
                                        <a href="<?= site_url('blocked_periods') ?>" class="btn btn-primary">
                                            <i class="fas fa-cogs me-2"></i>
                                            <?= lang('configure') ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 field-col">
                                <h4 class="text-black-50 mb-4"><?= lang('allow_rescheduling_cancellation_before') ?></h4>

                                <div class="mb-5">
                                    <label for="book-advance-timeout" class="form-label mb-2">
                                        <?= lang('timeout_minutes') ?>
                                    </label>
                                    <input id="book-advance-timeout" data-field="book_advance_timeout" type="number" min="15" class="form-control border border-primary">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('book_advance_timeout_hint') ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 field-col">
                                <h4 class="text-black-50 mb-4"><?= lang('future_booking_limit') ?></h4>

                                <div class="mb-5">
                                    <label for="future-booking-limit" class="form-label mb-2">
                                        <?= lang('limit_days') ?>
                                    </label>
                                    <input id="future-booking-limit" data-field="future_booking_limit" type="number" min="15" class="form-control border border-primary">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('future_booking_limit_hint') ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 field-col">
                                <h4 class="text-black-50 mb-4"><?= lang('appointment_status_options') ?></h4>

                                <p class="form-text text-muted mb-4">
                                    <?= lang('appointment_status_options_info') ?>
                                </p>

                                <?php component('appointment_status_options', [
                                    'attributes' => 'id="appointment-status-options"',
                                ]); ?>

                                <?php slot('after_primary_fields'); ?>
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

<script src="<?= asset_url('assets/js/core/jquery.jeditable.min.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/utils/working_plan.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/business_settings_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/business_settings.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
