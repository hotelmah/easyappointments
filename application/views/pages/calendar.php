<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="calendar-page" class="container-fluid backend-page">
    <div id="calendar-toolbar" class="row">
        <div id="calendar-filter" class="col-md-3">
            <div class="calendar-filter-items">
                <select id="select-filter-item" class="form-select col" data-tippy-content="<?= lang('select_filter_item_hint') ?>" aria-label="Filter">
                    <!-- JS -->
                </select>
            </div>
        </div>

        <div id="calendar-actions" class="col-md-9">
            <?php if (vars('calendar_view') === CALENDAR_VIEW_DEFAULT) : ?>
                <button id="enable-sync" class="btn btn-light" data-tippy-content="<?= lang('enable_appointment_sync_hint') ?>" hidden>
                    <i class="fas fa-rotate me-2"></i>
                    <?= lang('enable_sync') ?>
                </button>

                <div id="sync-button-group" class="btn-group" hidden>
                    <button id="trigger-sync" type="button" class="btn btn-light" data-tippy-content="<?= lang('trigger_sync_hint') ?>">
                        <i class="fas fa-rotate me-2"></i>
                        <?= lang('synchronize') ?>
                    </button>
                    <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">
                            Toggle Dropdown
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="#" id="disable-sync" class="dropdown-item">
                                <?= lang('disable_sync') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (can('add', PRIV_APPOINTMENTS)) : ?>
                <div class="dropdown d-sm-inline-block">
                    <button type="button" data-bs-toggle="dropdown" class="btn btn-light dropdown-toggle">
                        <i class="fas fa-plus-square"></i>
                        <?= lang('add') ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" id="insert-appointment" class="dropdown-item">
                                <?= lang('appointment') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="insert-unavailability" class="dropdown-item">
                                <?= lang('unavailability') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="insert-working-plan-exception" class="dropdown-item" <?= session('role_slug') !== DB_SLUG_ADMIN ? 'hidden' : '' ?>>
                                <?= lang('working_plan_exception') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <button id="reload-appointments" class="btn btn-light" data-tippy-content="<?= lang('reload_appointments_hint') ?>">
                <i class="fas fa-sync-alt"></i>
                <?= lang('reload') ?>
            </button>

            <?php if (vars('calendar_view') === CALENDAR_VIEW_DEFAULT) : ?>
                <a class="btn btn-light mb-0" href="<?= site_url('calendar?view=table') ?>" data-tippy-content="<?= lang('table') ?>">
                    <i class="fas fa-table"></i>
                    <?= lang('view') ?>
                </a>
            <?php endif; ?>

            <?php if (vars('calendar_view') === CALENDAR_VIEW_TABLE) : ?>
                <a href="<?= site_url('calendar?view=default') ?>" class="btn btn-light mb-0" data-tippy-content="<?= lang('default') ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <?= lang('view') ?>
                </a>
            <?php endif; ?>

            <?php slot('after_calendar_actions'); ?>
        </div>
    </div>

    <div id="calendar">
        <!-- Dynamically Generated Content -->
    </div>
</div>

<!-- Page Components -->

<?php component('appointments_modal', [
    'available_services' => vars('available_services'),
    'appointment_status_options' => vars('appointment_status_options'),
    'timezones' => vars('timezones'),
    'require_first_name' => vars('require_first_name'),
    'require_last_name' => vars('require_last_name'),
    'require_email' => vars('require_email'),
    'require_mobile_number' => vars('require_mobile_number'),
    'require_work_number' => vars('require_work_number'),
    'require_address' => vars('require_address'),
    'require_city' => vars('require_city'),
    'require_state' => vars('require_state'),
    'require_zip_code' => vars('require_zip_code'),
    'require_notes' => vars('require_notes'),
]); ?>

<?php component('unavailabilities_modal', [
    'timezones' => vars('timezones'),
    'timezone' => vars('timezone'),
]); ?>

<?php component('working_plan_exceptions_modal'); ?>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/moment@6.1.17/index.global.min.js" type="text/javascript"></script>

<script src="<?= asset_url('assets/js/utils/calendar_default_view.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/utils/calendar_table_view.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/utils/calendar_event_popover.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/calendar_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/http/customers_http_client.js') ?>" type="text/javascript"></script>
<?php if (vars('calendar_view') === CALENDAR_VIEW_DEFAULT) : ?>
    <script src="<?= asset_url('assets/js/utils/calendar_sync.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/http/google_http_client.js') ?>" type="text/javascript"></script>
    <script src="<?= asset_url('assets/js/http/caldav_http_client.js') ?>" type="text/javascript"></script>
<?php endif; ?>
<script src="<?= asset_url('assets/js/pages/calendar.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
