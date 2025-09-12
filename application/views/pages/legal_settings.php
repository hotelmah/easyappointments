<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="legal-settings-page" class="container backend-page">
    <div id="legal-contents">
        <div class="row">
            <div class="col-sm-3 offset-sm-1">
                <?php component('settings_nav'); ?>
            </div>
            <div class="col-sm-6">
                <form>
                    <fieldset>
                        <div class="settings-header border-bottom mb-3 py-3">
                            <h3 class="text-black-50 mb-0">
                                <?= lang('legal_contents') ?>
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
                                <h4 class="text-black-50 mb-4"><?= lang('cookie_notice') ?></h4>

                                <div class="form-check form-switch mb-3">
                                    <input id="display-cookie-notice" type="checkbox" class="form-check-input display-switch border border-primary">
                                    <label for="display-cookie-notice" class="form-check-label">
                                        <?= lang('display_cookie_notice') ?>
                                    </label>
                                </div>

                                <div class="mb-5">
                                    <label for="cookie-notice-content" class="form-label mb-2"><?= lang('cookie_notice_content') ?></label>
                                    <textarea id="cookie-notice-content" cols="30" rows="10" class="border border-primary mb-3"></textarea>
                                </div>

                                <h4 class="text-black-50 mb-4"><?= lang('terms_and_conditions') ?></h4>

                                <div class="form-check form-switch mb-3">
                                    <input id="display-terms-and-conditions" type="checkbox" class="form-check-input display-switch border border-primary">
                                    <label for="display-terms-and-conditions" class="form-check-label">
                                        <?= lang('display_terms_and_conditions') ?>
                                    </label>
                                </div>

                                <div class="mb-5">
                                    <label for="terms-and-conditions-content" class="form-label mb-2"><?= lang('terms_and_conditions_content') ?></label>
                                    <textarea id="terms-and-conditions-content" cols="30" rows="10" class="border border-primary mb-3"></textarea>
                                </div>

                                <h4 class="text-black-50 mb-4"><?= lang('privacy_policy') ?></h4>

                                <div class="form-check form-switch mb-3">
                                    <input id="display-privacy-policy" type="checkbox" class="form-check-input display-switch border border-primary">
                                    <label for="display-privacy-policy" class="form-check-label">
                                        <?= lang('display_privacy_policy') ?>
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <label for="privacy-policy-content" class="form-label mb-2"><?= lang('privacy_policy_content') ?></label>
                                    <textarea id="privacy-policy-content" cols="30" rows="10" class="border border-primary mb-3"></textarea>
                                </div>
                            </div>
                        </div>

                        <?php slot('after_primary_fields'); ?>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/http/legal_settings_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/legal_settings.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
