<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="webhooks-page" class="container-fluid backend-page">
    <div id="webhooks-toolbar" class="row">
        <div id="webhooks-filter" class="col-md-5">
            <form id="filter-webhooks-form">
                <div class="input-group">
                    <input type="text" class="key form-control border border-primary" aria-label="keyword" placeholder="<?= lang('search_webhooks_placeholder') ?>" data-tippy-content="<?= lang('search_webhooks_hint') ?>" autocomplete="off">
                    <div class="btn-group">
                        <button type="submit" class="filter btn btn-light" data-tippy-content="<?= lang('filter') ?>">
                            <i class="fas fa-search"></i>
                            <?= lang('search') ?>
                        </button>
                        <button id="clear-webhooks" type="button" class="btn btn-light" data-tippy-content="<?= lang('clear') ?>">
                            <i class="fas fa-times"></i>
                            <?= lang('clear') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="webhooks-actions" class="col-md-7">
            <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2">
                <a href="<?= site_url('integrations') ?>" class="btn btn-primary me-3" data-tippy-content="<?= lang('back') ?>">
                    <i class="fas fa-chevron-left me-2"></i>
                    <?= lang('back') ?>
                </a>

                <div id="add-edit-delete-group">
                    <button id="add-webhook" class="btn btn-light" data-tippy-content="<?= lang('add_webhook_hint') ?>">
                        <i class="fas fa-plus-square me-2"></i>
                        <?= lang('add') ?>
                    </button>

                    <button id="edit-webhook" class="btn btn-light" data-tippy-content="<?= lang('edit_webhook_hint') ?>" disabled>
                        <i class="fas fa-edit me-2"></i>
                        <?= lang('edit') ?>
                    </button>

                    <button id="delete-webhook" class="btn btn-light" data-tippy-content="<?= lang('delete_webhook_hint') ?>" disabled>
                        <i class="fas fa-trash-alt me-2"></i>
                        <?= lang('delete') ?>
                    </button>
                </div>

                <div id="save-cancel-group" style="display:none;">
                    <button id="save-webhook" class="btn btn-success" data-tippy-content="<?= lang('save') ?>">
                        <i class="fas fa-check-square me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    <button id="cancel-webhook" class="btn btn-light" data-tippy-content="<?= lang('cancel') ?>">
                        <i class="fas fa-times-circle me-2"></i>
                        <?= lang('cancel') ?>
                    </button>
                </div>
            </div>
            <?php slot('after_page_actions'); ?>
        </div>
    </div>

    <div id="webhooks" class="row g-4">
        <div class="col-12 col-md-4 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('webhooks') ?>
            </h4>

            <?php slot('after_page_title'); ?>

            <div id="webhooks-list" class="results border rounded p-3">
                <!-- JS -->
            </div>
        </div>

        <div class="record-details column col-12 col-md-5 field-col">
            <h4 class="text-black-50 mb-3">
                <?= lang('details') ?>
            </h4>

            <div class="form-message alert" style="display:none;"></div>

            <input id="webhook-id" type="hidden">

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
                        <label for="url" class="form-label mb-2">
                            <?= lang('url') ?>
                            <span class="text-danger" hidden>*</span>
                        </label>
                        <input id="url" type="text" class="required form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="secret-header" class="form-label mb-2">
                            <?= lang('secret_header') ?>
                        </label>
                        <input id="secret-header" type="text" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="secret-token" class="form-label mb-2">
                            <?= lang('secret_token') ?>
                        </label>
                        <input id="secret-token" type="text" class="form-control border border-primary ps-2 disabled" maxlength="100" disabled>
                    </div>

                    <div>
                        <label for="actions" class="form-label mb-4">
                            <?= lang('actions') ?>
                        </label>
                    </div>

                    <div class="border rounded mb-3 p-3">
                        <div id="actions">
                            <?php foreach (vars('available_actions') as $available_action) : ?>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input border border-primary" type="checkbox"
                                            id="include-<?= str_replace('_', '-', $available_action) ?>"
                                            data-action="<?= $available_action ?>">

                                        <label class="form-check-label"
                                            for="include-<?= str_replace('_', '-', $available_action) ?>">
                                            <?= lang($available_action) ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <label class="form-label mb-4">
                            <?= lang('options') ?>
                        </label>
                    </div>

                    <div class="border rounded mb-3 p-3">
                        <div class="form-check form-switch">
                            <input id="is-ssl-verified" type="checkbox" class="form-check-input border border-primary">
                            <label for="is-ssl-verified" class="form-check-label">
                                <?= lang('verify_ssl') ?>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label mb-2">
                            <?= lang('notes') ?>
                        </label>
                        <textarea id="notes" rows="4" class="form-control border border-primary disabled" disabled></textarea>
                    </div>

                    <?php slot('after_primary_fields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/webhooks_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/webhooks.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
