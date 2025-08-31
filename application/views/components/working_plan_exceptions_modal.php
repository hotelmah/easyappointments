<div id="working-plan-exceptions-modal" class="modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= lang('working_plan_exception') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-black-50 mb-3"><?= lang('date') ?></h4>
                <div class="ms-3 mb-4">
                    <input id="working-plan-exceptions-date" class="form-control border border-primary" data-tippy-content="<?= lang('select_date') ?>">
                    <label for="working-plan-exceptions-date" class="form-label ms-2"><?= lang('workplan_exceptions_date_hint') ?></label>
                </div>

                <h4 class="text-black-50 mb-3"><?= lang('working_not_working') ?></h4>
                <div class="ms-3 mb-4">
                    <div class="form-check form-switch">
                        <input id="working-plan-exceptions-is-non-working-day" type="checkbox" class="form-check-input border border-primary" data-tippy-content="<?= lang('toggle_working') ?>">
                        <label for="working-plan-exceptions-is-non-working-day" class="form-check-label ms-3" data-tippy-content="<?= lang('toggle_working') ?>">
                            <?= lang('make_non_working_day') ?>
                        </label>
                    </div>
                </div>

                <h4 class="text-black-50 mb-3"><?= lang('workplan_exception_start_end') ?></h4>
                <div class="row ms-3 mb-4">
                    <div class="col-sm-6">
                        <div>
                            <label for="working-plan-exceptions-start" class="form-label"><?= lang('start') ?></label>
                            <input id="working-plan-exceptions-start" class="form-control border border-primary w-75" data-tippy-content="<?= lang('select_start_time') ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div>
                            <label for="working-plan-exceptions-end" class="form-label"><?= lang('end') ?></label>
                            <input id="working-plan-exceptions-end" class="form-control border border-primary w-75" data-tippy-content="<?= lang('select_end_time') ?>">
                        </div>
                    </div>
                </div>

                <h4 class="text-black-50 mb-3"><?= lang('breaks') ?></h4>

                <p>
                    <?= lang('workplan_exception_breaks_date') ?>
                </p>

                <div>
                    <button type="button" class="working-plan-exceptions-add-break btn btn-primary" data-tippy-content="<?= lang('add_break') ?>">
                        <i class="fas fa-plus-square me-2"></i>
                        <?= lang('add_break') ?>
                    </button>
                </div>

                <br>

                <table id="working-plan-exceptions-breaks" class="table table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th><?= lang('start') ?></th>
                        <th><?= lang('end') ?></th>
                        <th><?= lang('actions') ?></th>
                    </tr>
                    </thead>
                    <tbody><!-- Dynamic Content --></tbody>
                </table>

                <?php slot('after_primary_working_plan_exception_fields'); ?>
            </div>
            <div class="modal-footer bg-light">
                <?php slot('before_working_plan_exception_actions'); ?>

                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal" data-tippy-content="<?= lang('cancel') ?>">
                    <i class="fas fa-times-circle me-2"></i>
                    <?= lang('cancel') ?>
                </button>
                <button id="working-plan-exceptions-save" type="button" class="btn btn-primary" data-tippy-content="<?= lang('save') ?>">
                    <i class="fas fa-check-square me-2"></i>
                    <?= lang('save') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/components/working_plan_exceptions_modal.js') ?>"></script>

<?php end_section('scripts'); ?>
