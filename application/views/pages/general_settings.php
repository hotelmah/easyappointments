<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div id="general-settings-page" class="container backend-page">
    <div id="general-settings">
        <div class="row">
            <div class="col-sm-3 offset-sm-1">
                <?php component('settings_nav'); ?>
            </div>
            <div class="col-sm-6">
                <form>
                    <fieldset>
                        <div class="settings-header border-bottom mb-3 py-3">
                            <h3 class="text-black-50 mb-0">
                                <?= lang('general_settings') ?>
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
                                <h4 class="text-black-50 mb-4"><?= lang('company') ?></h4>

                                <div class="mb-4">
                                    <label for="company-name" class="form-label mb-2">
                                        <?= lang('company_name') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="company-name" type="text" data-field="company_name" class="required form-control border border-primary">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('company_name_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="company-email" class="form-label mb-2">
                                        <?= lang('company_email') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="company-email" type="email" data-field="company_email" class="required form-control border border-primary">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('company_email_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="company-link" class="form-label mb-2">
                                        <?= lang('company_link') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input id="company-link" type="text" data-field="company_link" class="required form-control border border-primary">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('company_link_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="company-logo" class="form-label mb-2">
                                        <?= lang('company_logo') ?>
                                    </label>
                                    <input id="company-logo" type="file" data-field="company_logo" class="form-control border border-primary" accept="image/*">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('company_logo_hint') ?>
                                        </small>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <img id="company-logo-preview" src="#" alt="Company Logo Preview" class="img-thumbnail my-3" hidden>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-danger mb-3" id="remove-company-logo" hidden>
                                            <i class="fas fa-trash me-2"></i>
                                            <?= lang('remove') ?>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="company-color" class="form-label mb-2">
                                        <?= lang('company_color') ?>
                                    </label>

                                    <input id="company-color" type="color" data-field="company_color" class="form-control border border-primary">
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('company_color_hint') ?>
                                        </small>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button id="reset-company-color" type="button" class="btn btn-danger my-3" hidden>
                                            <i class="fas fa-undo-alt me-2"></i>
                                            <?= lang('reset') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12 field-col">
                                <h4 class="text-black-50 mb-4"><?= lang('localization') ?></h4>

                                <div class="mb-4">
                                    <label for="date-format" class="form-label mb-2">
                                        <?= lang('date_format') ?>
                                    </label>
                                    <select id="date-format" data-field="date_format" class="form-select border border-primary">
                                        <option value="DMY">DMY</option>
                                        <option value="MDY">MDY</option>
                                        <option value="YMD">YMD</option>
                                    </select>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('date_format_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="time-format" class="form-label mb-2">
                                        <?= lang('time_format') ?>
                                    </label>
                                    <select id="time-format" data-field="time_format" class="form-select border border-primary">
                                        <option value="<?= TIME_FORMAT_REGULAR ?>">H:MM AM/PM</option>
                                        <option value="<?= TIME_FORMAT_MILITARY ?>">HH:MM</option>
                                    </select>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('time_format_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="first-weekday" class="form-label mb-2">
                                        <?= lang('first_weekday') ?>
                                    </label>
                                    <select id="first-weekday" data-field="first_weekday" class="form-select border border-primary">
                                        <option value="sunday"><?= lang('sunday') ?></option>
                                        <option value="monday"><?= lang('monday') ?></option>
                                        <option value="tuesday"><?= lang('tuesday') ?></option>
                                        <option value="wednesday"><?= lang('wednesday') ?></option>
                                        <option value="thursday"><?= lang('thursday') ?></option>
                                        <option value="friday"><?= lang('friday') ?></option>
                                        <option value="saturday"><?= lang('saturday') ?></option>
                                    </select>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('first_weekday_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="default-language" class="form-label mb-2">
                                        <?= lang('default_language') ?>
                                        <span class="text-danger" hidden>*</span>
                                    </label>
                                    <select id="default-language" class="required form-select border border-primary" data-field="default_language">
                                        <?php foreach (vars('available_languages') as $available_language) : ?>
                                            <option value="<?= $available_language ?>">
                                                <?= ucfirst($available_language) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('default_language_hint') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="default-timezone" class="form-label mb-2">
                                        <?= lang('default_timezone') ?>
                                        <span class="text-danger" hidden>*</span>
                                    </label>
                                    <?php component('timezone_dropdown', [
                                        'attributes' => 'id="default-timezone" data-field="default_timezone" class="required form-select border border-primary"',
                                        'grouped_timezones' => vars('grouped_timezones')
                                    ]); ?>

                                    <div class="form-text text-muted">
                                        <small>
                                            <?= lang('default_timezone_hint') ?>
                                        </small>
                                    </div>
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

<script src="<?= asset_url('assets/js/http/general_settings_http_client.js') ?>" type="text/javascript"></script>
<script src="<?= asset_url('assets/js/pages/general_settings.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
