<?php
/**
 * Local variables.
 *
 * @var string $display_first_name
 * @var string $require_first_name
 * @var string $display_last_name
 * @var string $require_last_name
 * @var string $display_email
 * @var string $require_email
 * @var string $display_mobile_number
 * @var string $require_mobile_number
 * @var string $display_work_number
 * @var string $require_work_number
 * @var string $display_address
 * @var string $require_address
 * @var string $display_city
 * @var string $require_city
* @var string $display_state
 * @var string $require_state
 * @var string $display_zip_code
 * @var string $require_zip_code
 * @var string $display_notes
 * @var string $require_notes
 */
?>

<div id="wizard-frame-3" class="wizard-frame" style="display:none;">
    <div class="frame-container">
        <h4 class="frame-title"><?= vars('customer_information_title') ?></h4>

        <div class="row">
            <div class="col-12 col-md-6 field-col">
                <?php if ($display_first_name) : ?>
                    <div class="mb-1">
                        <label for="first-name" class="form-label"><?= lang('first_name') ?>
                            <?php if ($require_first_name) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="first-name" class="<?= $require_first_name ? 'required' : '' ?> form-control border border-primary" maxlength="60" />
                    </div>
                <?php endif; ?>

                <?php if ($display_last_name) : ?>
                    <div class="mb-1">
                        <label for="last-name" class="form-label"><?= lang('last_name') ?>
                            <?php if ($require_last_name) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="last-name" class="<?= $require_last_name ? 'required' : '' ?> form-control border border-primary" maxlength="60"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_email) : ?>
                    <div class="mb-1">
                        <label for="email" class="form-label"><?= lang('email') ?>
                            <?php if ($require_email) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="email" id="email" class="<?= $require_email ? 'required' : '' ?> form-control border border-primary" maxlength="60"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_mobile_number) : ?>
                    <div class="mb-1">
                        <label for="mobile-phone-number" class="form-label"><?= lang('mobile_phone_number') ?>
                            <?php if ($require_mobile_number) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="tel" id="mobile-phone-number" maxlength="15" class="<?= $require_mobile_number ? 'required' : '' ?> form-control border border-primary"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_work_number) : ?>
                    <div class="mb-1">
                        <label for="work-phone-number" class="form-label"><?= lang('work_phone_number') ?>
                            <?php if ($require_work_number) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="tel" id="work-phone-number" maxlength="15" class="<?= $require_work_number ? 'required' : '' ?> form-control border border-primary"/>
                    </div>
                <?php endif; ?>

                <?php slot('info_first_column'); ?>

                <?php component('custom_fields'); ?>

                <?php slot('after_custom_fields'); ?>
            </div>

            <div class="col-12 col-md-6 field-col">
                <?php if ($display_address) : ?>
                    <div class="mb-1">
                        <label for="address" class="form-label"><?= lang('address') ?>
                            <?php if ($require_address) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="address" class="<?= $require_address ? 'required' : '' ?> form-control border border-primary" maxlength="120"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_city) : ?>
                    <div class="mb-1">
                        <label for="city" class="form-label"><?= lang('city') ?>
                            <?php if ($require_city) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="city" class="<?= $require_city ? 'required' : '' ?> form-control border border-primary" maxlength="120"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_state) : ?>
                    <div class="mb-1">
                        <label for="state" class="form-label"><?= lang('state') ?>
                            <?php if ($require_state) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="state" class="<?= $require_state ? 'required' : '' ?> form-control border border-primary" maxlength="120"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_zip_code) : ?>
                    <div class="mb-1">
                        <label for="zip-code" class="form-label"><?= lang('zip_code') ?>
                            <?php if ($require_zip_code) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="zip-code" class="<?= $require_zip_code ? 'required' : '' ?> form-control border border-primary" maxlength="60"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_notes) : ?>
                    <div class="mb-1">
                        <label for="notes" class="form-label"><?= lang('notes') ?>
                            <?php if ($require_notes) : ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <textarea id="notes" maxlength="500" class="<?= $require_notes ? 'required' : '' ?> form-control border border-primary" rows="2"></textarea>
                    </div>
                <?php endif; ?>

                <?php slot('info_second_column'); ?>
            </div>
        </div>
    </div>

    <div class="command-buttons">
        <button type="button" id="button-back-3" class="btn button-back btn-outline-secondary" data-step_index="3">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <button type="button" id="button-next-3" class="btn button-next btn-dark" data-step_index="3">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>