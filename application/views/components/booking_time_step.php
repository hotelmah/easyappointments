<?php
/**
 * Local variables.
 *
 * @var array $grouped_timezones
 */
?>

<div id="wizard-frame-2" class="wizard-frame" style="display:none;">
    <div class="frame-container">
        <h4 class="frame-title"><?= lang('appointment_date_and_time') ?></h4>

        <div class="row align-items-start">
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div id="select-date"></div>
                <?php slot('after_select_date'); ?>
            </div>

            <div class="col-12 col-md-6">
                <div id="select-time">
                    <div id="available-hours"></div>

                    <?php slot('after_available_hours'); ?>

                    <div>
                        <label for="select-timezone" class="form-label"><?= lang('timezone') ?></label>
                        <?php component('timezone_dropdown', [
                            'attributes' => 'id="select-timezone" class="form-select" value="UTC"',
                            'grouped_timezones' => $grouped_timezones,
                        ]); ?>
                    </div>

                    <?php slot('after_select_timezone'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="command-buttons">
        <button type="button" id="button-back-2" class="btn button-back btn-outline-secondary"
                data-step_index="2">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <button type="button" id="button-next-2" class="btn button-next btn-dark"
                data-step_index="2">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>
