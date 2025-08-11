<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="services-page" class="container-fluid backend-page">
    <div id="services-toolbar" class="row">
        <!-- Left side: Search/Filter -->
        <div id="services-filter" class="col-md-5">
            <form id="filter-services-form">
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
        <div id="services-actions" class="col-md-7">
            <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                <div id="add-edit-delete-group">

                        <button id="add-service" class="btn btn-light" data-tippy-content="<?= lang('add_service_hint') ?>">
                            <i class="fas fa-plus-square me-2"></i>
                            <?= lang('add') ?>
                        </button>

                        <button id="edit-service" class="btn btn-light" data-tippy-content="<?= lang('edit_service_hint') ?>" disabled>
                            <i class="fas fa-edit me-2"></i>
                            <?= lang('edit') ?>
                        </button>

                        <button id="delete-service" class="btn btn-light" data-tippy-content="<?= lang('delete_service_hint') ?>" disabled>
                            <i class="fas fa-trash-alt me-2"></i>
                            <?= lang('delete') ?>
                        </button>
                </div>

                <div id="save-cancel-group" style="display:none;">
                    <button id="save-service" class="btn btn-success">
                        <i class="fas fa-check-square me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    <button id="cancel-service" class="btn btn-light">
                        <i class="fas fa-times-circle me-2"></i>
                        <?= lang('cancel') ?>
                    </button>
                </div>
            </div>
            <?php slot('after_page_actions'); ?>
        </div>
    </div>


    <div id="services" class="row g-4">
        <div class="col-12 col-md-4 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('services') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="services-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-7 field-col">
            <div class="record-details row">
                <input id="service-id" type="hidden">

                <div class="col-12 col-md-6 field-col">
                    <h4 class="text-black-50 mb-3">
                        <?= lang('details') ?>
                    </h4>

                    <div id="form-message" class="alert" style="display:none;"></div>

                    <div class="mb-4">
                        <label for="name" class="form-label mb-2">
                            <?= lang('name') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input type="text" id="name" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="duration" class="form-label mb-2">
                            <?= lang('duration_minutes') ?>

                                <span class="text-danger" hidden>*</span>

                        </label>
                        <input id="duration" type="number" class="required form-control border border-primary ps-2 disabled" min="<?= EVENT_MINIMUM_DURATION ?>" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="form-label mb-2">
                            <?= lang('price') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="price" type="number" step="0.01" class="required form-control border border-primary ps-2 disabled" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="currency" class="form-label mb-2">
                            <?= lang('currency') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="currency" type="text" maxlength="32" class="required form-control border border-primary ps-2 disabled" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="service-category-id" class="form-label mb-2">
                            <?= lang('category') ?>
                        </label>
                        <select id="service-category-id" class="form-control border border-primary ps-2 disabled" disabled></select>
                    </div>

                    <div class="mb-4">
                        <label for="availabilities-type" class="form-label mb-2">
                            <?= lang('availabilities_type') ?>
                        </label>
                        <select id="availabilities-type" class="form-select border border-primary ps-2 disabled" disabled>
                            <option value="<?= AVAILABILITIES_TYPE_FLEXIBLE ?>">
                                <?= lang('flexible') ?>
                            </option>
                            <option value="<?= AVAILABILITIES_TYPE_FIXED ?>">
                                <?= lang('fixed') ?>
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="attendants-number" class="form-label mb-2">
                            <?= lang('attendants_number') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input type="number" id="attendants-number" class="required form-control border border-primary ps-2 disabled" min="1" disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="location" class="form-label mb-2">
                            <?= lang('location') ?>
                        </label>
                        <input type="text" id="location" class="form-control border border-primary ps-2 disabled" maxlength="125" disabled/>
                    </div>

                    <div class="mb-4">
                        <?php component('color_selection', ['attributes' => 'id="color"']); ?>
                    </div>

                    <div>
                        <label class="form-label mb-3">
                            <?= lang('options') ?>
                        </label>
                    </div>

                    <div class="border rounded mb-3 p-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is-private">

                            <label class="form-check-label" for="is-private">
                                <?= lang('hide_from_public') ?>
                            </label>
                        </div>

                        <div class="form-text text-muted">
                            <small>
                                <?= lang('private_hint') ?>
                            </small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label mb-2" for="description">
                            <?= lang('description') ?>
                        </label>
                        <textarea id="description" rows="4" class="form-control border border-primary ps-2 disabled" disabled></textarea>
                    </div>

                    <?php slot('after_primary_fields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/services_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/service_categories_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/pages/services.js') ?>"></script>

<?php end_section('scripts'); ?>
