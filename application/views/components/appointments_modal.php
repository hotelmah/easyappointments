<?php
/**
 * Local variables.
 *
 * @var array $available_services
 * @var array $appointment_status_options
 * @var array $timezones
 * @var array $require_first_name
 * @var array $require_last_name
 * @var array $require_email
 * @var array $require_phone_number
 * @var array $require_address
 * @var array $require_city
 * @var array $require_zip_code
 * @var array $require_notes
 */
?>
<div id="appointments-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?= lang('edit_appointment_title') ?></h3>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="modal-message alert d-none"></div>

                <form>
                    <fieldset>
                        <h5 class="text-black-50 border-bottom mb-3 py-1"><?= lang('appointment_details_title') ?></h5>

                        <input id="appointment-id" type="hidden">

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="select-service" class="form-label mb-2">
                                        <?= lang('service') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="select-service" class="required form-select border border-primary">
                                        <?php
                                        // Group services by category, only if there is at least one service
                                        // with a parent category.
                                        $has_category = false;

                                        foreach ($available_services as $service) {
                                            if (!empty($service['category_id'])) {
                                                $has_category = true;
                                                break;
                                            }
                                        }

                                        if ($has_category) {
                                            $grouped_services = [];

                                            foreach ($available_services as $service) {
                                                if (!empty($service['category_id'])) {
                                                    if (!isset($grouped_services[$service['category_name']])) {
                                                        $grouped_services[$service['category_name']] = [];
                                                    }

                                                    $grouped_services[$service['category_name']][] = $service;
                                                }
                                            }

                                            // We need the uncategorized services at the end of the list, so we will use
                                            // another iteration only for the uncategorized services.
                                            $grouped_services['uncategorized'] = [];

                                            foreach ($available_services as $service) {
                                                if ($service['category_id'] == null) {
                                                    $grouped_services['uncategorized'][] = $service;
                                                }
                                            }

                                            foreach ($grouped_services as $key => $group) {
                                                $group_label =
                                                    $key !== 'uncategorized'
                                                        ? e($group[0]['category_name'])
                                                        : 'Uncategorized';

                                                if (count($group) > 0) {
                                                    echo '<optgroup label="' . $group_label . '">';

                                                    foreach ($group as $service) {
                                                        echo '<option value="' .
                                                            $service['id'] .
                                                            '">' .
                                                            e($service['name']) .
                                                            '</option>';
                                                    }

                                                    echo '</optgroup>';
                                                }
                                            }
                                        } else {
                                            foreach ($available_services as $service) {
                                                echo '<option value="' .
                                                    $service['id'] .
                                                    '">' .
                                                    e($service['name']) .
                                                    '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <?php slot('after_select_appointment_service'); ?>

                                <div class="mb-3">
                                    <label for="select-provider" class="form-label mb-2">
                                        <?= lang('provider') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="select-provider" class="required form-select border border-primary"></select>
                                </div>

                                <?php slot('after_select_appointment_provider'); ?>

                                <div class="mb-3">
                                    <?php component('color_selection', ['attributes' => 'id="appointment-color"']); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="appointment-location" class="form-label mb-2">
                                        <?= lang('location') ?>
                                    </label>
                                    <input id="appointment-location" class="form-control border border-primary">
                                </div>

                                <div class="mb-3">
                                    <label for="appointment-status" class="form-label mb-2">
                                        <?= lang('status') ?>
                                    </label>
                                    <select id="appointment-status" class="form-select border border-primary">
                                        <?php foreach ($appointment_status_options as $appointment_status_option) : ?>
                                            <option value="<?= e($appointment_status_option) ?>">
                                                <?= e($appointment_status_option) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="start-datetime" class="form-label mb-2 d-block"><?= lang('start_date_time') ?></label>
                                    <input id="start-datetime" class="required form-control border border-primary">
                                </div>

                                <div class="mb-3">
                                    <label for="end-datetime" class="form-label mb-2 d-block"><?= lang('end_date_time') ?></label>
                                    <input id="end-datetime" class="required form-control border border-primary">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label mb-2">
                                        <?= lang('timezone') ?>
                                    </label>

                                    <div class="timezone-info d-flex justify-content-between align-items-center border border-primary rounded w-75">
                                        <div class="border-end w-50 p-1 text-center">
                                            <small>
                                                <?= lang('provider') ?>:
                                                <span class="provider-timezone">
                                                    -
                                                </span>
                                            </small>
                                        </div>
                                        <div class="w-50 p-1 text-center">
                                            <small>
                                                <?= lang('current_user') ?>:
                                                <span>
                                                    <?= $timezones[session('timezone', 'UTC')] ?>
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="appointment-notes" class="form-label mb-2"><?= lang('notes') ?></label>
                                    <textarea id="appointment-notes" class="form-control border border-primary" rows="4"></textarea>
                                </div>

                                <?php slot('after_primary_appointment_fields'); ?>
                            </div>
                        </div>
                    </fieldset>

                    <?php slot('after_appointment_details'); ?>

                    <br>

                    <fieldset>
                        <h5 class="text-black-50 border-bottom mb-3 py-1">
                            <?= lang('customer_details_title') ?>
                        </h5>
                        <div class="border-bottom mb-2 py-2">
                            <button id="new-customer" type="button" class="btn btn-primary" data-tippy-content="<?= lang('clear_fields_add_existing_customer_hint') ?>">
                                <i class="fas fa-plus-square me-2"></i>
                                <?= lang('new') ?>
                            </button>
                            <button id="select-customer" type="button" class="btn btn-primary" data-tippy-content="<?= lang('pick_existing_customer_hint') ?>">
                                <i class="fas fa-hand-pointer me-2"></i>
                                <?= lang('select') ?>
                            </button>

                            <input id="filter-existing-customers" placeholder="<?= lang('type_to_filter_customers') ?>" style="display: none;" class="form-control border border-primary">
                        </div>

                        <div id="existing-customers-list" class="border rounded py-2" style="display: none;"></div>

                        <input id="customer-id" type="hidden">

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="first-name" class="form-label mb-2">
                                        <?= lang('first_name') ?>
                                        <?php if ($require_first_name) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="first-name" type="text" class="<?= $require_first_name ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="last-name" class="form-label mb-2">
                                        <?= lang('last_name') ?>
                                        <?php if ($require_last_name) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="last-name" type="text" class="<?= $require_last_name ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label mb-2">
                                        <?= lang('email') ?>
                                        <?php if ($require_email) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="email" type="email" class="<?= $require_email ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="mobile-phone-number" class="form-label mb-2">
                                        <?= lang('mobile_phone_number') ?>
                                        <?php if ($require_mobile_number) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="mobile-phone-number" type="tel" maxlength="60" class="<?= $require_mobile_number ? 'required' : '' ?> form-control border border-primary">
                                </div>

                                <div class="mb-3">
                                    <label for="work-phone-number" class="form-label mb-2">
                                        <?= lang('work_phone_number') ?>
                                        <?php if ($require_work_number) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="work-phone-number" type="tel" maxlength="60" class="<?= $require_work_number ? 'required' : '' ?> form-control border border-primary">
                                </div>

                                <div class="mb-3">
                                    <label for="language" class="form-label mb-2">
                                        <?= lang('language') ?>
                                        <span class="text-danger" hidden>*</span>
                                    </label>
                                    <select id="language" class="required form-select border border-primary">
                                        <?php foreach (vars('available_languages') as $available_language) : ?>
                                            <option value="<?= $available_language ?>">
                                                <?= ucfirst($available_language) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <?php component('custom_fields'); ?>

                                <?php slot('after_primary_customer_custom_fields'); ?>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label mb-2">
                                        <?= lang('address') ?>
                                        <?php if ($require_address) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="address" type="text" class="<?= $require_address ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label mb-2">
                                        <?= lang('city') ?>
                                        <?php if ($require_city) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="city" type="text" class="<?= $require_city ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="state" class="form-label mb-2">
                                        <?= lang('state') ?>
                                        <?php if ($require_state) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="state" type="text" class="<?= $require_state ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="zip-code" class="form-label mb-2">
                                        <?= lang('zip_code') ?>
                                        <?php if ($require_zip_code) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="zip-code" type="text" class="<?= $require_zip_code ? 'required' : '' ?> form-control border border-primary" maxlength="100">
                                </div>

                                <div class="mb-3">
                                    <label for="timezone" class="form-label mb-2">
                                        <?= lang('timezone') ?>
                                        <span class="text-danger" hidden>*</span>
                                    </label>
                                    <?php component('timezone_dropdown', [
                                        'attributes' => 'id="timezone" class="required form-select border border-primary"',
                                        'grouped_timezones' => vars('grouped_timezones'),
                                    ]); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="customer-notes" class="form-label mb-2">
                                        <?= lang('notes') ?>
                                        <?php if ($require_notes) : ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <textarea id="customer-notes" rows="2" class="<?= $require_notes ? 'required' : '' ?> form-control border border-primary"></textarea>
                                </div>

                                <?php slot('after_primary_customer_fields'); ?>
                            </div>
                        </div>
                    </fieldset>

                    <?php slot('after_customer_details'); ?>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <?php slot('before_appointment_actions'); ?>

                <button class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fas fa-times-circle me-2"></i>
                    <?= lang('cancel') ?>
                </button>
                <button id="save-appointment" class="btn btn-primary">
                    <i class="fas fa-check-square me-2"></i>
                    <?= lang('save') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/components/appointments_modal.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
