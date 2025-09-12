<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="blocked-periods-page" class="container-fluid backend-page">
    <div id="blocked-periods-toolbar" class="row">
        <div id="blocked-periods-filter" class="col-md-5">
            <form id="filter-blocked-periods-form">
                <div class="input-group">
                    <input type="text" class="key form-control border border-primary" aria-label="keyword" placeholder="<?= lang('search_blocked_periods_placeholder') ?>" data-tippy-content="<?= lang('search_blocked_periods_hint') ?>" autocomplete="off">
                    <div class="btn-group">
                        <button type="submit" class="filter btn btn-light" data-tippy-content="<?= lang('filter') ?>">
                            <i class="fas fa-search"></i>
                            <?= lang('search') ?>
                        </button>
                        <button id="clear-blocked-periods" type="button" class="btn btn-light" data-tippy-content="<?= lang('clear') ?>">
                            <i class="fas fa-times"></i>
                            <?= lang('clear') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="blocked-periods-actions" class="col-md-7">
            <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                <a href="<?= site_url('business_settings') ?>" class="btn btn-primary me-3" data-tippy-content="<?= lang('back') ?>">
                    <i class="fas fa-chevron-left me-2"></i>
                    <?= lang('back') ?>
                </a>

                <div id="add-edit-delete-group">
                    <button id="add-blocked-period" class="btn btn-light" data-tippy-content="<?= lang('add_blocked_period_hint') ?>">
                        <i class="fas fa-plus-square me-2"></i>
                        <?= lang('add') ?>
                    </button>

                    <button id="edit-blocked-period" class="btn btn-light" data-tippy-content="<?= lang('edit_blocked_period_hint') ?>" disabled>
                        <i class="fas fa-edit me-2"></i>
                        <?= lang('edit') ?>
                    </button>

                    <button id="delete-blocked-period" class="btn btn-light" data-tippy-content="<?= lang('delete_blocked_period_hint') ?>" disabled>
                        <i class="fas fa-trash-alt me-2"></i>
                        <?= lang('delete') ?>
                    </button>
                </div>

                <div id="save-cancel-group" style="display:none;">
                    <button id="save-blocked-period" class="btn btn-success" data-tippy-content="<?= lang('save') ?>">
                        <i class="fas fa-check-square me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    <button id="cancel-blocked-period" class="btn btn-light" data-tippy-content="<?= lang('cancel') ?>">
                        <i class="fas fa-times-circle me-2"></i>
                        <?= lang('cancel') ?>
                    </button>
                </div>
            </div>
            <?php slot('after_page_actions'); ?>
        </div>
    </div>

    <div id="blocked-periods" class="row g-4">
        <div class="col-12 col-md-4 field-col">
            <!-- input-append -->
            <h4 class="text-black-50 mb-3">
                <?= lang('blocked_periods') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="blocked-periods-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="record-details column col-12 col-md-5 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('details') ?>
            </h4>

            <div class="form-message alert" style="display:none;"></div>

            <input id="blocked-period-id" type="hidden" class="record-id">

            <div class="row">
                <div class="details col-12 col-md-6">
                    <div class="mb-4">
                        <label for="name" class="form-label mb-2">
                            <?= lang('name') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="name" type="text" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="start-date-time" class="form-label mb-2 d-block">
                            <?= lang('start') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="start-date-time" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="end-date-time" class="form-label mb-2 d-block">
                            <?= lang('end') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="end-date-time" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label mb-2">
                            <?= lang('notes') ?>
                        </label>
                        <textarea id="notes" rows="4" class="form-control border border-primary ps-2 disabled" disabled></textarea>
                    </div>

                    <?php slot('after_primary_fields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/blocked_periods_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/blocked_periods.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
