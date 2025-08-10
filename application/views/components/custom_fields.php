<?php

/**
 * Local variables.
 *
 * @var bool $disabled (false)
 */

$disabled = $disabled ?? false;
?>

<?php for ($i = 1; $i <= 5; $i++) : ?>
    <?php if (setting('display_custom_field_' . $i)) : ?>
        <div class="mb-4">
            <label for="custom-field-<?= $i ?>" class="form-label mb-2">
                <?= setting('label_custom_field_' . $i) ?: lang('custom_field') . ' #' . $i ?>
                <?php if (setting('require_custom_field_' . $i)) : ?>
                    <span class="text-danger" <?= $disabled ? 'hidden' : '' ?>>*</span>
                <?php endif; ?>
            </label>
            <input type="text" id="custom-field-<?= $i ?>" name="<?= setting('label_custom_field_' . $i) ?>" class="<?= setting('require_custom_field_' . $i) ? 'required' : '' ?> form-control border border-primary ps-2 <?= $disabled ? 'disabled' : '' ?>" maxlength="60" <?= $disabled ? 'disabled' : '' ?>/>
        </div>
    <?php endif; ?>
<?php endfor; ?>
