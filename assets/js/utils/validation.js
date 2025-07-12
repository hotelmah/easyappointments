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
 * Validation utility.
 *
 * This module implements the functionality of validation.
 */
window.App.Utils.Validation = (function () {
    /**
     * Validate the provided email.
     *
     * @param {String} value
     *
     * @return {Boolean}
     */
    function email(value) {
        if (!value || typeof value !== 'string') {
            return false;
        }

        value = value.trim();

        // Check for empty after trim
        if (!value) {
            return false;
        }

        // Simple and effective email validation regex
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        return re.test(value);
    }



    /**
     * Validate the provided phone.
     *
     * @param {String} value
     *
     * @return {Boolean}
     */
    function isValidIntlPhone(value) {
        if (!value || typeof value !== 'string') {
            return false;
        }

        // Trim whitespace
        value = value.trim();

        // Remove all non-digits except leading +
        const cleaned = value.replace(/[^\d+]/g, '');

        // Valid international phone number: 7-15 digits, optional + prefix
        const re = /^\+?[1-9]\d{6,14}$/;

        return re.test(cleaned);
    }



    /**
     * Validate the provided phone.
     *
     * @param {String} value
     *
     * @return {Boolean}
     */
    function isValidUSTelephone(phone) {
        // Accepts formats like:
        // (123) 456-7890, 123-456-7890, 123.456.7890, 1234567890, +1 123 456 7890
        const regex = /^(?:\+1\s?)?(?:\([2-9]\d{2}\)|[2-9]\d{2}|[2-9]\d{2})[\s.-]?\d{3}[\s.-]?\d{4}$|^(?:\+1\s?)?[2-9]\d{2}[2-9]\d{6}$/;
        return regex.test(phone.trim());
    }



    /**
     * Display an alert.
     *
     * @param {String} message
     *
     * @return {void}
     */
    function showBookingAlert(message) {
        // Remove existing alert if present
        const existingAlert = document.getElementById('booking-alert');
        if (existingAlert) {
            const bsAlert = bootstrap.Alert.getInstance(existingAlert);
            if (bsAlert) {
                bsAlert.close();
            }
        }

        // Create new alert element
        const alertHTML = `
            <div id="booking-alert" class="alert alert-warning alert-dismissible" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Insert into DOM (adjust selector based on where you want it)
        const container = document.querySelector('#book-appointment-wizard') || document.body;
        container.insertAdjacentHTML('afterbegin', alertHTML);

        // Initialize Bootstrap Alert
        const newAlert = document.getElementById('booking-alert');
        const bsAlert = new bootstrap.Alert(newAlert);

        // Optional: Auto-hide after 10 seconds, but clear if closed manually
        const timeoutId = setTimeout(() => {
            // Only close if still in DOM
            if (document.getElementById('booking-alert')) {
                bsAlert.close();
            }
        }, 10000);

        // Clear timeout if alert is closed manually
        newAlert.addEventListener('closed.bs.alert', () => {
            clearTimeout(timeoutId);
        });
    }

    return {
        email,
        isValidIntlPhone,
        isValidUSTelephone,
        showBookingAlert
    };
})();