<?php
/**
 * @var string $attributes
 */
?>

<div <?= $attributes ?? '' ?> class="appointment-status-options">
    <ul class="list-group">
        <!-- JS -->
    </ul>

    <button type="button" class="add-appointment-status-option btn btn-primary" title="<?= lang('add') ?>" data-tippy-content="<?= lang('add') ?>">
        <i class="fas fa-plus-square me-2"></i>
        <?= lang('add') ?>
    </button>
</div>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/components/appointment_status_options.js') ?>" type="text/javascript"></script>

<?php end_section('scripts'); ?>
