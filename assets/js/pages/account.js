/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * Account page.
 *
 * This module implements the functionality of the account page.
 */
App.Pages.Account = (function () {
    const $userId = $('#user-id');
    const $firstName = $('#first-name');
    const $lastName = $('#last-name');
    const $email = $('#email');
    const $mobilePhoneNumber = $('#mobile-phone-number');
    const $workPhoneNumber = $('#work-phone-number');
    const $address = $('#address');
    const $city = $('#city');
    const $state = $('#state');
    const $zipCode = $('#zip-code');
    const $notes = $('#notes');
    const $language = $('#language');
    const $timezone = $('#timezone');
    const $username = $('#username');
    const $password = $('#password');
    const $retypePassword = $('#retype-password');
    const $calendarView = $('#calendar-view');
    const $notifications = $('#notifications');
    const $saveSettings = $('#save-settings');
    const $footerUserDisplayName = $('#footer-user-display-name');

    /**
     * Check if the form has invalid values.
     *
     * @return {Boolean}
     */
    function isInvalid() {
        $('#account .is-invalid').removeClass('is-invalid');
        $('#account .form-message').removeClass('alert-danger').hide();

        try {
            // Validate required fields.
            let missingRequiredFields = false;

            // Validate passwords (if values provided).
            if ($password.val() && $password.val() !== $retypePassword.val()) {
                $password.addClass('is-invalid');
                $retypePassword.addClass('is-invalid');
                throw new Error(lang('passwords_mismatch'));
            }

            if ($password.val().length < vars('min_password_length') && $password.val() !== '') {
                $password.addClass('is-invalid');
                $retypePassword.addClass('is-invalid');
                throw new Error(lang('password_length_notice').replace('$number', vars('min_password_length')));
            }

            // Validate user email.
            if (!App.Utils.Validation.email($email.val())) {
                $email.addClass('is-invalid');
                throw new Error(lang('invalid_email'));
            }

            // Validate mobile number.
            const mobilePhoneNumber = $mobilePhoneNumber.val();

            if (mobilePhoneNumber && !App.Utils.Validation.isValidUSTelephone(mobilePhoneNumber)) {
                $mobilePhoneNumber.addClass('is-invalid');
                throw new Error(lang('invalid_phone'));
            }

            // Validate phone number.
            const workPhoneNumber = $workPhoneNumber.val();

            if (workPhoneNumber && !App.Utils.Validation.isValidUSTelephone(workPhoneNumber)) {
                $workPhoneNumber.addClass('is-invalid');
                throw new Error(lang('invalid_phone'));
            }

            // Check if username exists
            if ($username.attr('already-exists') === 'true') {
                $username.addClass('is-invalid');
                throw new Error(lang('username_already_exists'));
            }

            if ($username.hasClass('is-invalid')) {
                throw new Error(lang('username_already_exists'));
            }

            $('#account .required').each((index, requiredField) => {
                const $requiredField = $(requiredField);

                if (!$requiredField.val()) {
                    $requiredField.addClass('is-invalid');
                    missingRequiredFields = true;
                }
            });

            if (missingRequiredFields) {
                throw new Error(lang('fields_are_required'));
            }

            return false;
        } catch (error) {
            // App.Layouts.Backend.displayNotification(error.message);
            $('#account .form-message').addClass('alert-danger').text(error.message).show();
            return true;
        }
    }

    /**
     * Apply the account values to the form.
     *
     * @param {Object} account
     */
    function deserialize(account) {
        $userId.val(account.id);
        $firstName.val(account.first_name);
        $lastName.val(account.last_name);
        $email.val(account.email);
        $mobilePhoneNumber.val(account.mobile_phone_number);
        $workPhoneNumber.val(account.work_phone_number);
        $address.val(account.address);
        $city.val(account.city);
        $state.val(account.state);
        $zipCode.val(account.zip_code);
        $notes.val(account.notes);
        $username.val(account.settings.username);
        $password.val('');
        $retypePassword.val('');
        $calendarView.val(account.settings.calendar_view);
        $language.val(account.language);
        $timezone.val(account.timezone);
        $notifications.prop('checked', Boolean(Number(account.settings.notifications)));
    }

    /**
     * Get the account information from the form.
     *
     * @return {Object}
     */
    function serialize() {
        return {
            id: $userId.val(),
            first_name: $firstName.val(),
            last_name: $lastName.val(),
            email: $email.val(),
            mobile_phone_number: $mobilePhoneNumber.val(),
            work_phone_number: $workPhoneNumber.val(),
            address: $address.val(),
            city: $city.val(),
            state: $state.val(),
            zip_code: $zipCode.val(),
            notes: $notes.val(),
            language: $language.val(),
            timezone: $timezone.val(),
            settings: {
                username: $username.val(),
                password: $password.val() || undefined,
                calendar_view: $calendarView.val(),
                notifications: Number($notifications.prop('checked')),
            },
        };
    }

    /**
     * Save the account information.
     */
    function onSaveSettingsClick() {
        if (isInvalid()) {
            App.Layouts.Backend.displayNotification(lang('user_settings_are_invalid'));

            return;
        }

        const account = serialize();

        App.Http.Account.save(account).done(() => {
            App.Layouts.Backend.displayNotification(lang('settings_saved'));

            $footerUserDisplayName.text('Hello, ' + $firstName.val() + ' ' + $lastName.val() + '!');
        });
    }

    /**
     * Make sure the username is unique.
     */
    function onUsernameChange() {
        $('.form-message').removeClass('alert-danger').hide();

        if ($username.prop('readonly') === true || $username.val() === '') {
            return;
        }

        // const adminId = $input.parents().eq(2).find('.record-id').val();
        const userId = $('#user-id').val();

        if (!userId) {
            return;
        }

        const username = $username.val();

        App.Http.Account.validateUsername(userId, username).done((response) => {
            if (response.is_valid === false) {
                $username.removeClass('border-primary').addClass('is-invalid border-danger');
                $username.attr('already-exists', 'true');
                $('.form-message').addClass('alert-danger').text(lang('username_already_exists')).show();
            } else {
                $username.removeClass('is-invalid border-danger').addClass('border-primary');
                $username.attr('already-exists', 'false');
                if ($('.form-message').text() === lang('username_already_exists')) {
                    $('.form-message').removeClass('alert-danger').hide();
                }
            }
        });
    }

    /**
     * Initialize the page.
     */
    function initialize() {
        const account = vars('account');

        deserialize(account);

        $saveSettings.on('click', onSaveSettingsClick);

        $username.on('change', onUsernameChange);
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {};
})();
