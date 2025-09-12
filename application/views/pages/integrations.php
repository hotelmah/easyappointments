<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="integrations-page" class="container backend-page">
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
            <?php component('settings_nav'); ?>
        </div>
        <div id="integrations" class="col-sm-6">
            <h3 class="text-black-50 border-bottom mb-3 py-3">
                <?= lang('integrations') ?>
            </h3>

            <p class="form-text text-muted mb-4">
                <?= lang('integrations_info') ?>
            </p>

            <div class="row">
                <div class="col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="text-black-50 mb-0">
                                <?= lang('webhooks') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="integration-info mb-3">
                                <small>
                                    <?= lang('webhooks_info') ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <a href="<?= site_url('webhooks') ?>" class="btn btn-outline-primary w-100" title="<?= lang('webhooks') ?>" aria-label="<?= lang('webhooks') ?>" target="_self">
                                <i class="fas fa-cogs me-2"></i>
                                <?= lang('configure') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="text-black-50 mb-0">
                                <?= lang('google_analytics') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="integration-info mb-3">
                                <small>
                                    <?= lang('google_analytics_info') ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <a href="<?= site_url('google_analytics_settings') ?>" class="btn btn-outline-primary w-100" title="<?= lang('google_analytics') ?>" aria-label="<?= lang('google_analytics') ?>" target="_self">
                                <i class="fas fa-cogs me-2"></i>
                                <?= lang('configure') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="text-black-50 mb-0">
                                <?= lang('matomo_analytics') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="integration-info mb-3">
                                <small>
                                    <?= lang('matomo_analytics_info') ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <a href="<?= site_url('matomo_analytics_settings') ?>" class="btn btn-outline-primary w-100" title="<?= lang('matomo_analytics') ?>" aria-label="<?= lang('matomo_analytics') ?>" target="_self">
                                <i class="fas fa-cogs me-2"></i>
                                <?= lang('configure') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="text-black-50 mb-0">
                                <?= lang('api') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="integration-info mb-3">
                                <small>
                                    <?= lang('api_info') ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <a href="<?= site_url('api_settings') ?>" class="btn btn-outline-primary w-100" title="<?= lang('api') ?>" aria-label="<?= lang('api') ?>" target="_self">
                                <i class="fas fa-cogs me-2"></i>
                                <?= lang('configure') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="text-black-50 mb-0">
                                <?= lang('ldap') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="integration-info mb-3">
                                <small>
                                    <?= lang('ldap_info') ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <a href="<?= site_url('ldap_settings') ?>" class="btn btn-outline-primary w-100" title="<?= lang('ldap') ?>" aria-label="<?= lang('ldap') ?>" target="_self">
                                <i class="fas fa-cogs me-2"></i>
                                <?= lang('configure') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php slot('after_integration_cards'); ?>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/pages/integrations.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
