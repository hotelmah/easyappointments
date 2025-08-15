<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="service-categories-page" class="container-fluid backend-page">
    <div id="service-categories-toolbar" class="row">
        <div id="service-categories-filter" class="col-md-5">
            <form id="filter-service-categories-form">
                <div class="input-group">
                    <input type="text" class="key form-control border-primary" aria-label="keyword" placeholder="<?= lang('search_service_categories_placeholder') ?>" data-tippy-content="<?= lang('search_service_categories_hint') ?>" autocomplete="off">
                    <div class="btn-group">
                        <button class="filter btn btn-light" type="submit" data-tippy-content="<?= lang('filter') ?>">
                            <i class="fas fa-search"></i>
                            <?= lang('search') ?>
                        </button>
                        <button id="clear-service-categories" class="btn btn-light" type="button" data-tippy-content="<?= lang('clear') ?>">
                            <i class="fas fa-times"></i>
                            <?= lang('clear') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="services-categories-actions" class="col-md-7">
            <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                <div id="add-edit-delete-group">
                    <button id="add-service-category" class="btn btn-light" data-tippy-content="<?= lang('add_service_category_hint') ?>">
                        <i class="fas fa-plus-square me-2"></i>
                        <?= lang('add') ?>
                    </button>

                    <button id="edit-service-category" class="btn btn-light" data-tippy-content="<?= lang('edit_service_category_hint') ?>" disabled>
                        <i class="fas fa-edit me-2"></i>
                        <?= lang('edit') ?>
                    </button>

                    <button id="delete-service-category" class="btn btn-light" data-tippy-content="<?= lang('delete_service_category_hint') ?>" disabled>
                        <i class="fas fa-trash-alt me-2"></i>
                        <?= lang('delete') ?>
                    </button>
                </div>

                <div id="save-cancel-group" style="display:none;">
                    <button id="save-service-category" class="btn btn-success">
                        <i class="fas fa-check-square me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    <button id="cancel-service-category" class="btn btn-light">
                        <i class="fas fa-times-circle me-2"></i>
                        <?= lang('cancel') ?>
                    </button>
                </div>
            </div>
            <?php slot('after_page_actions'); ?>
        </div>
    </div>

    <div id="service-categories" class="row g-4">
        <div class="col-12 col-md-3 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('service_categories') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="service-categories-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-7 field-col">
            <div class="record-details row">
                <input id="service-category-id" type="hidden">

                <div class="col-12 col-md-6 field-col">
                    <h4 class="text-black-50 mb-3">
                        <?= lang('details') ?>
                    </h4>

                    <div class="mb-4">
                        <label for="name" class="form-label mb-2">
                            <?= lang('name') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="name" type="text" class="required form-control border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label mb-2">
                            <?= lang('description') ?>
                        </label>
                        <textarea id="description" rows="4" class="form-control border-primary ps-2 disabled" disabled></textarea>
                    </div>

                    <?php slot('after_primary_fields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/service_categories_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/service_categories.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
