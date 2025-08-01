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
 * Messages utility.
 *
 * This module implements the functionality of messages.
 */
window.App.Utils.Message = (function () {
    let messageModal = null;

    /**
     * Show a message box to the user.
     *
     * This functions displays a message box in the admin array. It is useful when user
     * decisions or verifications are needed.
     *
     * @param {String} title The title of the message box.
     * @param {String} message The message of the dialog.
     * @param {Array} [buttons] Contains the dialog buttons along with their functions.
     * @param {Boolean} [isDismissible] If true, the button will show the close X in the header and close with the press of the Escape button.
     *
     * @return {jQuery|null} Return the #message-modal selector or null if the arguments are invalid.
     */
    function show(title, message, buttons = null, isDismissible = true) {
        if (!title || !message) {
            return null;
        }

        if (!buttons) {
            buttons = [
                {
                    text: lang('try_again'),
                    className: 'btn btn-outline-primary',
                    isDefault: true,
                    click: function (event, messageModal) {
                        messageModal.hide();
                        // Just close modal, keep current state
                    }
                },
                {
                    text: lang('start_over'),
                    className: 'btn btn-secondary me-2',
                    click: function (event, messageModal) {
                        messageModal.hide();

                        // Reset data and navigate to main screen
                        resetApplicationData();
                        navigateToMainScreen();
                    }
                }
            ];
        }

        if (messageModal?.dispose && messageModal?.hide && messageModal?._element) {
            messageModal.hide();
            messageModal.dispose();
            messageModal = undefined;
        }

        $('#message-modal').remove();

        const $messageModal = $(`
            <div class="modal" id="message-modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                ${title}
                            </h5>
                            ${
                                isDismissible
                                    ? '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
                                    : ''
                            }
                        </div>
                        <div class="modal-body">
                            ${message}
                        </div>
                        <div class="modal-footer">
                            <!-- * -->
                        </div>
                    </div>
                </div>
            </div>
        `).appendTo('body');

        buttons.forEach((button) => {
            if (!button) {
                return;
            }

            if (!button.className) {
                button.className = 'btn btn-outline-primary';
            }

            const $button = $(`
                <button type="button" class="${button.className}">
                    ${button.text}
                </button>
            `).appendTo($messageModal.find('.modal-footer'));

            if (button.click) {
                $button.on('click', (event) => button.click(event, messageModal));
            }
        });

        messageModal = new bootstrap.Modal('#message-modal', {
            keyboard: isDismissible,
            backdrop: 'static',
        });

        $messageModal.on('shown.bs.modal', () => {
            $messageModal
                .find('.modal-footer button:last')
                .removeClass('btn-outline-primary')
                .addClass('btn-primary')
                .trigger('focus');
        });

        messageModal.show();

        $messageModal.css('z-index', '99999').next().css('z-index', '9999');

        return $messageModal;
    }


    /**
    * Reset application data to initial state
    */
    function resetApplicationData() {
        // Clear form data
        $('form').each(function() {
            this.reset();
        });

        // Clear any stored form data
        if (typeof Storage !== "undefined") {
            localStorage.removeItem('post_data');
            sessionStorage.clear();
        }

        // Reset booking wizard if present
        if (window.App.Pages.Booking) {
            // Reset to step 1
            $('.wizard-frame').hide();
            $('#wizard-frame-1').show();

            // Clear selections
            $('#select-service').val('').trigger('change');
            $('#select-provider').val('').trigger('change');
            $('#select-date').val('');
            $('#available-hours').empty();

            // Clear customer form
            $('#first-name, #last-name, #email, #phone-number, #address, #city, #zip-code, #customer-notes').val('');
        }

        // Clear any validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.alert').addClass('d-none');
    }

    /**
    * Navigate to main screen
    */
    function navigateToMainScreen() {
        // Option 1: Reload the page completely
        window.location.reload();

        // Option 2: Navigate to booking start page (uncomment if preferred)
        // window.location.href = App.Utils.Url.siteUrl('booking');

        // Option 3: Navigate to home page (uncomment if preferred)
        // window.location.href = vars('base_url');
    }

    return {
        show,
    };
})();
