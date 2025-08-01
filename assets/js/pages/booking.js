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
 * Booking page.
 *
 * This module implements the functionality of the booking page
 *
 * Old Name: FrontendBook
 */
App.Pages.Booking = (function () {
    const $selectDate = $('#select-date');
    const $selectService = $('#select-service');
    const $selectProvider = $('#select-provider');
    const $selectTimezone = $('#select-timezone');
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
    const $captchaTitle = $('.captcha-title');
    const $availableHours = $('#available-hours');
    const $bookAppointmentSubmit = $('#book-appointment-submit');
    const $deletePersonalInformation = $('#delete-personal-information');
    const $customField1 = $('#custom-field-1');
    const $customField2 = $('#custom-field-2');
    const $customField3 = $('#custom-field-3');
    const $customField4 = $('#custom-field-4');
    const $customField5 = $('#custom-field-5');
    const $displayBookingSelection = $('.display-booking-selection');
    const tippy = window.tippy;
    const moment = window.moment;

    /**
     * Determines the functionality of the page.
     *
     * @type {Boolean}
     */
    let manageMode = vars('manage_mode') || false;

    /**
     * Detect the month step.
     *
     * @param previousDateTimeMoment
     * @param nextDateTimeMoment
     *
     * @returns {Number}
     */
    function detectDatepickerMonthChangeStep(previousDateTimeMoment, nextDateTimeMoment) {
        return previousDateTimeMoment.isAfter(nextDateTimeMoment) ? -1 : 1;
    }

    /**
     * Initialize the module.
     */
    function initialize() {
        if (Boolean(Number(vars('display_cookie_notice'))) && window?.cookieconsent) {
            cookieconsent.initialise({
                palette: {
                    popup: {
                        background: '#ffffffbd',
                        text: '#666666',
                    },
                    button: {
                        background: '#429a82',
                        text: '#ffffff',
                    },
                },
                content: {
                    message: lang('website_using_cookies_to_ensure_best_experience'),
                    dismiss: 'OK',
                },
            });

            const $cookieNoticeLink = $('.cc-link');

            $cookieNoticeLink.replaceWith(
                $('<a/>', {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#cookie-notice-modal',
                    'href': '#',
                    'class': 'cc-link',
                    'text': $cookieNoticeLink.text(),
                }),
            );
        }

        manageMode = vars('manage_mode');

        // Initialize page's components (tooltips, date pickers etc).
        tippy('[data-tippy-content]');

        let monthTimeout;

        App.Utils.UI.initializeDatePicker($selectDate, {
            inline: true,
            minDate: moment().subtract(1, 'day').set({hours: 23, minutes: 59, seconds: 59}).toDate(),
            maxDate: moment().add(vars('future_booking_limit'), 'days').toDate(),
            onChange: (selectedDates) => {
                App.Http.Booking.getAvailableHours(moment(selectedDates[0]).format('YYYY-MM-DD'));
                App.Pages.Booking.updateConfirmFrame();
            },

            onMonthChange: (selectedDates, dateStr, instance) => {
                $selectDate.parent().fadeTo(400, 0.3); // Change opacity during loading

                if (monthTimeout) {
                    clearTimeout(monthTimeout);
                }

                monthTimeout = setTimeout(() => {
                    const previousMoment = moment(instance.selectedDates[0]);

                    const displayedMonthMoment = moment(
                        instance.currentYearElement.value +
                            '-' +
                            String(Number(instance.monthsDropdownContainer.value) + 1).padStart(2, '0') +
                            '-01',
                    );

                    const monthChangeStep = detectDatepickerMonthChangeStep(previousMoment, displayedMonthMoment);

                    App.Http.Booking.getUnavailableDates(
                        $selectProvider.val(),
                        $selectService.val(),
                        displayedMonthMoment.format('YYYY-MM-DD'),
                        monthChangeStep,
                    );
                }, 500);
            },

            onYearChange: (selectedDates, dateStr, instance) => {
                setTimeout(() => {
                    const previousMoment = moment(instance.selectedDates[0]);

                    const displayedMonthMoment = moment(
                        instance.currentYearElement.value +
                            '-' +
                            (Number(instance.monthsDropdownContainer.value) + 1) +
                            '-01',
                    );

                    const monthChangeStep = detectDatepickerMonthChangeStep(previousMoment, displayedMonthMoment);

                    App.Http.Booking.getUnavailableDates(
                        $selectProvider.val(),
                        $selectService.val(),
                        displayedMonthMoment.format('YYYY-MM-DD'),
                        monthChangeStep,
                    );
                }, 500);
            },
        });

        App.Utils.UI.setDateTimePickerValue($selectDate, new Date());

        const browserTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        const isTimezoneSupported = $selectTimezone.find(`option[value="${browserTimezone}"]`).length > 0;
        $selectTimezone.val(isTimezoneSupported ? browserTimezone : 'UTC');

        // Bind the event handlers (might not be necessary every time we use this class).
        addEventListeners();

        optimizeContactInfoDisplay();

        const serviceOptionCount = $selectService.find('option').length;

        if (serviceOptionCount === 2) {
            $selectService.find('option[value=""]').remove();
            const firstServiceId = $selectService.find('option:first').attr('value');
            $selectService.val(firstServiceId).trigger('change');
        }

        // If the manage mode is true, the appointment data should be loaded by default.
        if (manageMode) {
            applyAppointmentData(vars('appointment_data'), vars('provider_data'), vars('customer_data'));

            $('#wizard-frame-1')
                .css({
                    'visibility': 'visible',
                    'display': 'none',
                })
                .fadeIn();
        } else {
            // Check if a specific service was selected (via URL parameter).
            const selectedServiceId = App.Utils.Url.queryParam('service');

            if (selectedServiceId && $selectService.find('option[value="' + selectedServiceId + '"]').length > 0) {
                $selectService.val(selectedServiceId);
            }

            $selectService.trigger('change'); // Load the available hours.

            // Check if a specific provider was selected.
            const selectedProviderId = App.Utils.Url.queryParam('provider');

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length === 0) {
                // Select a service of this provider in order to make the provider available in the select box.
                for (const index in vars('available_providers')) {
                    const provider = vars('available_providers')[index];

                    if (Number(provider.id) === Number(selectedProviderId) && provider.services.length > 0) {
                        $selectService.val(provider.services[0]).trigger('change');
                    }
                }
            }

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length > 0) {
                $selectProvider.val(selectedProviderId).trigger('change');
            }

            if (
                (selectedServiceId && selectedProviderId) ||
                (vars('available_services').length === 1 && vars('available_providers').length === 1)
            ) {
                if (!selectedServiceId) {
                    $selectService.val(vars('available_services')[0].id).trigger('change');
                }

                if (!selectedProviderId) {
                    $selectProvider.val(vars('available_providers')[0].id).trigger('change');
                }

                $('.active-step').removeClass('active-step');
                $('#step-2').addClass('active-step');
                $('#wizard-frame-1').hide();
                $('#wizard-frame-2').fadeIn();

                $selectService.closest('.wizard-frame').find('.button-next').trigger('click');

                $(document).find('.book-step:first').hide();

                $(document).find('.button-back:first').css('visibility', 'hidden');

                $(document)
                    .find('.book-step:not(:first)')
                    .each((index, bookStepEl) =>
                        $(bookStepEl)
                            .find('strong')
                            .text(index + 1),
                    );
            } else {
                $('#wizard-frame-1')
                    .css({
                        'visibility': 'visible',
                        'display': 'none',
                    })
                    .fadeIn();
            }

            prefillFromQueryParam('#first-name', 'first_name');
            prefillFromQueryParam('#last-name', 'last_name');
            prefillFromQueryParam('#email', 'email');
            prefillFromQueryParam('#mobile-phone-number', 'mobile_phone_number');
            prefillFromQueryParam('#work-phone-number', 'work_phone_number');
            prefillFromQueryParam('#address', 'address');
            prefillFromQueryParam('#city', 'city');
            prefillFromQueryParam('#state', 'state');
            prefillFromQueryParam('#zip-code', 'zip');
        }
    }

    function prefillFromQueryParam(field, param) {
        const $target = $(field);

        if (!$target.length) {
            return;
        }

        $target.val(App.Utils.Url.queryParam(param));
    }

    /**
     * Remove empty columns and center elements if needed.
     */
    function optimizeContactInfoDisplay() {
        // If a column has only one control shown then move the control to the other column.

        const $firstCol = $('#wizard-frame-3 .field-col:first');
        const $firstColControls = $firstCol.find('.form-control');
        const $secondCol = $('#wizard-frame-3 .field-col:last');
        const $secondColControls = $secondCol.find('.form-control');

        if ($firstColControls.length === 1 && $secondColControls.length > 1) {
            $firstColControls.each((index, controlEl) => {
                $(controlEl).parent().insertBefore($secondColControls.first().parent());
            });
        }

        if ($secondColControls.length === 1 && $firstColControls.length > 1) {
            $secondColControls.each((index, controlEl) => {
                $(controlEl).parent().insertAfter($firstColControls.last().parent());
            });
        }

        // Hide columns that do not have any controls displayed.

        const $fieldCols = $(document).find('#wizard-frame-3 .field-col');

        $fieldCols.each((index, fieldColEl) => {
            const $fieldCol = $(fieldColEl);

            if (!$fieldCol.find('.form-control').length) {
                $fieldCol.hide();
            }
        });
    }

    /**
     * Add the page event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Timezone "Changed"
         */
        $selectTimezone.on('change', () => {
            const date = App.Utils.UI.getDateTimePickerValue($selectDate);

            if (!date) {
                return;
            }

            App.Http.Booking.getAvailableHours(moment(date).format('YYYY-MM-DD'));

            App.Pages.Booking.updateConfirmFrame();
        });

        /**
         * Event: Selected Provider "Changed"
         *
         * Whenever the provider changes the available appointment date - time periods must be updated.
         */
        $selectProvider.on('change', (event) => {
            const $target = $(event.target);

            const todayDateTimeObject = new Date();
            const todayDateTimeMoment = moment(todayDateTimeObject);

            App.Utils.UI.setDateTimePickerValue($selectDate, todayDateTimeObject);

            App.Http.Booking.getUnavailableDates(
                $target.val(),
                $selectService.val(),
                todayDateTimeMoment.format('YYYY-MM-DD'),
            );

            App.Pages.Booking.updateConfirmFrame();
        });

        /**
         * Event: Selected Service "Changed"
         *
         * When the user clicks on a service, its available providers should
         * become visible.
         */
        $selectService.on('change', (event) => {
            const $target = $(event.target);
            const serviceId = $selectService.val();
            $selectProvider.parent().prop('hidden', !Boolean(serviceId));

            $selectProvider.empty();

            $selectProvider.append(new Option(lang('please_select'), ''));

            vars('available_providers').forEach((provider) => {
                // If the current provider is able to provide the selected service, add him to the list box.
                const canServeService =
                    provider.services.filter((providerServiceId) => Number(providerServiceId) === Number(serviceId))
                        .length > 0;

                if (canServeService) {
                    $selectProvider.append(new Option(provider.first_name + ' ' + provider.last_name, provider.id));
                }
            });

            const providerOptionCount = $selectProvider.find('option').length;

            // Remove the "Please Select" option, if there is only one provider available

            if (providerOptionCount === 2) {
                $selectProvider.find('option[value=""]').remove();
            }

            // Add the "Any Provider" entry

            if (providerOptionCount > 2 && Boolean(Number(vars('display_any_provider')))) {
                $(new Option(lang('any_provider'), 'any-provider')).insertAfter($selectProvider.find('option:first'));
            }

            App.Http.Booking.getUnavailableDates(
                $selectProvider.val(),
                $target.val(),
                moment(App.Utils.UI.getDateTimePickerValue($selectDate)).format('YYYY-MM-DD'),
            );

            App.Pages.Booking.updateConfirmFrame();

            App.Pages.Booking.updateServiceDescription(serviceId);
        });

        /**
         * Event: Next Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "next" button on the book wizard.
         * Some special tasks might be performed, depending on the current wizard step.
         */
        $('.button-next').on('click', (event) => {
            const $target = $(event.currentTarget);

            // If we are on the first step and there is no provider selected do not continue with the next step.
            if ($target.attr('data-step_index') === '1' && !$selectProvider.val()) {
                return;
            }

            // If we are on the 2nd tab then the user should have an appointment hour selected.
            if ($target.attr('data-step_index') === '2') {
                if (!$('.selected-hour').length) {
                    if (!$('#select-hour-prompt').length) {
                        $('<div/>', {
                            'id': 'select-hour-prompt',
                            'class': 'text-danger mb-4',
                            'text': lang('appointment_hour_missing'),
                        }).prependTo('#available-hours');
                    }
                    return;
                }
            }

            // If we are on the 3rd tab then we will need to validate the user's input before proceeding to the next
            // step.
            if ($target.attr('data-step_index') === '3') {
                if (!App.Pages.Booking.validateCustomerForm()) {
                    return; // Validation failed, do not continue.
                } else {
                    App.Pages.Booking.updateConfirmFrame();
                }
            }

            // Display the next step tab (uses jquery animation effect).
            const nextTabIndex = parseInt($target.attr('data-step_index')) + 1;

            $target
                .parents()
                .eq(1)
                .fadeOut(() => {
                    $('.active-step').removeClass('active-step');
                    $('#step-' + nextTabIndex).addClass('active-step');
                    $('#wizard-frame-' + nextTabIndex).fadeIn();
                });

            // Scroll to the top of the page. On a small screen, especially on a mobile device, this is very useful.
            const scrollingElement = document.scrollingElement || document.body;
            if (window.innerHeight < scrollingElement.scrollHeight) {
                scrollingElement.scrollTop = 0;
            }
        });

        /**
         * Event: Back Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "back" button on the
         * book wizard.
         */
        $('.button-back').on('click', (event) => {
            const prevTabIndex = parseInt($(event.currentTarget).attr('data-step_index')) - 1;

            $(event.currentTarget)
                .parents()
                .eq(1)
                .fadeOut(() => {
                    $('.active-step').removeClass('active-step');
                    $('#step-' + prevTabIndex).addClass('active-step');
                    $('#wizard-frame-' + prevTabIndex).fadeIn();
                });
        });

        /**
         * Event: Available Hour "Click"
         *
         * Triggered whenever the user clicks on an available hour for his appointment.
         */
        $availableHours.on('click', '.available-hour', (event) => {
            $availableHours.find('.selected-hour').removeClass('selected-hour');
            $(event.target).addClass('selected-hour');
            App.Pages.Booking.updateConfirmFrame();
        });

        if (manageMode) {
            /**
             * Event: Cancel Appointment Button "Click"
             *
             * When the user clicks the "Cancel" button this form is going to be submitted. We need
             * the user to confirm this action because once the appointment is cancelled, it will be
             * deleted from the database.
             *
             * @param {jQuery.Event} event
             */
            $('#cancel-appointment').on('click', () => {
                const $cancelAppointmentForm = $('#cancel-appointment-form');

                let $cancellationReason;

                const messageModal = App.Utils.Message.show(
                    lang('cancel_appointment_title'),
                    lang('write_appointment_removal_reason'),
                    [
                        {
                            text: lang('close'),
                            click: (event, messageModal) => {
                                messageModal.hide();
                            },
                        },
                        {
                            text: lang('confirm'),
                            click: () => {
                                // Check if element exists first
                                if (!$cancellationReason || !$cancellationReason.length) {
                                    console.error('Cancellation reason textarea not found');
                                    return;
                                }

                                const reasonValue = $cancellationReason.val();
                                console.log('Cancellation reason value:', `"${reasonValue}"`); // Debug log

                                if (!reasonValue || !reasonValue.trim()) {
                                    console.log('Setting red border - validation failed');
                                    $cancellationReason.css({
                                        'border': '2px solid #DC3545 !important',
                                        'box-shadow': '0 0 0 0.2rem rgba(220, 53, 69, 0.25)'
                                    });

                                    $cancellationReason.removeClass('border-primary').addClass('border-danger is-invalid');
                                    $cancellationReason.trigger('focus'); // Focus the field

                                    return;
                                }

                                // Validation passed
                                $cancelAppointmentForm.find('#hidden-cancellation-reason').val(reasonValue);
                                $cancelAppointmentForm.trigger('submit');
                            },
                        },
                    ]
                );


                // Create textarea AFTER modal is shown
                setTimeout(() => {
                    $cancellationReason = $('<textarea/>', {
                        'class': 'form-control mt-2 border border-primary',
                        'id': 'cancellation-reason',
                        'rows': '3',
                        'css': { 'width': '100%' },
                        'placeholder': 'Please provide a reason for cancellation...' // Add placeholder
                    }).appendTo('#message-modal .modal-body');

                    $cancellationReason.trigger('focus'); // Focus the textarea
                }, 100);


                return false;
            });

            $deletePersonalInformation.on('click', () => {
                const buttons = [
                    {
                        text: lang('cancel'),
                        click: (event, messageModal) => {
                            messageModal.hide();
                        },
                    },
                    {
                        text: lang('delete'),
                        click: () => {
                            App.Http.Booking.deletePersonalInformation(vars('customer_token'));
                        },
                    },
                ];

                App.Utils.Message.show(
                    lang('delete_personal_information'),
                    lang('delete_personal_information_prompt'),
                    buttons,
                );
            });
        }

        /**
         * Event: Book Appointment Form "Submit"
         *
         * Before the form is submitted to the server we need to make sure that in the meantime the selected appointment
         * date/time wasn't reserved by another customer or event.
         *
         * @param {jQuery.Event} event
         */
        $bookAppointmentSubmit.on('click', () => {
            const $acceptToTermsAndConditions = $('#accept-to-terms-and-conditions');

            $acceptToTermsAndConditions.removeClass('is-invalid');

            if ($acceptToTermsAndConditions.length && !$acceptToTermsAndConditions.prop('checked')) {
                $acceptToTermsAndConditions.addClass('is-invalid');
                return;
            }

            const $acceptToPrivacyPolicy = $('#accept-to-privacy-policy');

            $acceptToPrivacyPolicy.removeClass('is-invalid');

            if ($acceptToPrivacyPolicy.length && !$acceptToPrivacyPolicy.prop('checked')) {
                $acceptToPrivacyPolicy.addClass('is-invalid');
                return;
            }

            App.Http.Booking.registerAppointment();
        });

        /**
         * Event: Refresh captcha image.
         */
        $captchaTitle.on('click', 'button', () => {
            $('.captcha-image').attr('src', App.Utils.Url.siteUrl('captcha?' + Date.now()));
        });

        $selectDate.on('mousedown', '.ui-datepicker-calendar td', () => {
            setTimeout(() => {
                App.Http.Booking.applyPreviousUnavailableDates();
            }, 300);
        });
    }

    /**
     * This function validates the customer's data input. The user cannot continue without passing all the validation
     * checks.
     *
     * @return {Boolean} Returns the validation result.
     */
    function validateCustomerForm() {
        $('#wizard-frame-3 .is-invalid').removeClass('is-invalid').addClass('border border-primary');
        $('#wizard-frame-3 label.text-danger').removeClass('text-danger');

        // Ensure all required fields have the proper border styling
        $('#wizard-frame-3 .required').addClass('border border-primary');

        // Validate required fields.
        let missingRequiredField = false;

        $('.required').each((index, requiredField) => {
            if (!$(requiredField).val()) {
                $(requiredField).removeClass('border');
                $(requiredField).removeClass('border-primary');
                $(requiredField).addClass('is-invalid');
                missingRequiredField = true;
            }
        });

        if (missingRequiredField) {
            App.Utils.Validation.showBookingAlert(lang('fields_are_required'));

            return false;
        }

        // Validate email address.
        if ($email.val() && !App.Utils.Validation.email($email.val())) {
            $email.removeClass('border');
            $email.removeClass('border-primary');
            $email.addClass('is-invalid');
            App.Utils.Validation.showBookingAlert(lang('invalid_email'));

            return false;
        }

        // Validate phone number.
        const mobilePhoneNumber = $mobilePhoneNumber.val();

        if (mobilePhoneNumber && !App.Utils.Validation.isValidUSTelephone(mobilePhoneNumber)) {
            $mobilePhoneNumber.removeClass('border');
            $mobilePhoneNumber.removeClass('border-primary');
            $mobilePhoneNumber.addClass('is-invalid');
            App.Utils.Validation.showBookingAlert(lang('invalid_phone'));

            return false;
        }

        const workPhoneNumber = $workPhoneNumber.val();

        if (workPhoneNumber && !App.Utils.Validation.isValidUSTelephone(workPhoneNumber)) {
            $workPhoneNumber.removeClass('border');
            $workPhoneNumber.removeClass('border-primary');
            $workPhoneNumber.addClass('is-invalid');
            App.Utils.Validation.showBookingAlert(lang('invalid_phone'));

            return false;
        }

        return true;
    }

    /**
     * Every time this function is executed, it updates the confirmation page with the latest
     * customer settings and input for the appointment booking.
     */
    function updateConfirmFrame() {
        const serviceId = $selectService.val();
        const providerId = $selectProvider.val();

        $displayBookingSelection.text(`${lang('service')} │ ${lang('provider')}`); // Notice: "│" is a custom ASCII char

        const serviceOptionText = serviceId ? $selectService.find('option:selected').text() : lang('service');
        const providerOptionText = providerId ? $selectProvider.find('option:selected').text() : lang('provider');

        if (serviceId || providerId) {
            $displayBookingSelection.text(`${serviceOptionText} │ ${providerOptionText}`);
        }

        if (!$availableHours.find('.selected-hour').text()) {
            // App.Utils.Validation.showBookingAlert(lang('appointment_hour_missing'));
            return; // No time is selected, skip the rest of this function...
        }

        // Render the appointment details

        const service = vars('available_services').find(
            (availableService) => Number(availableService.id) === Number(serviceId),
        );

        if (!service) {
            // App.Utils.Validation.showBookingAlert(lang('service_not_found'));
            return; // Service was not found
        }

        const selectedDateObject = App.Utils.UI.getDateTimePickerValue($selectDate);
        const selectedDateMoment = moment(selectedDateObject);
        const selectedDate = selectedDateMoment.format('YYYY-MM-DD');
        const selectedTime = $availableHours.find('.selected-hour').text();

        let formattedSelectedDate = '';

        if (selectedDateObject) {
            formattedSelectedDate =
                App.Utils.Date.format(selectedDate, vars('date_format'), vars('time_format'), false) +
                ' ' +
                selectedTime;
        }

        const timezoneOptionText = $selectTimezone.find('option:selected').text();

        // Check for changes in appointment data (if in manage mode)
        let serviceChanged = false;
        let providerChanged = false;
        let dateTimeChanged = false;
        let timezoneChanged = false;

        if (manageMode) {
            const originalAppointment = vars('appointment_data');
            const originalCustomer = vars('customer_data');

            serviceChanged = hasFieldChanged(serviceId, originalAppointment.id_services);
            providerChanged = hasFieldChanged(providerId, originalAppointment.id_users_provider);

            // Check datetime change
            const currentDateTime = moment(selectedDateObject).format('YYYY-MM-DD') + ' ' +
                                moment($('.selected-hour').data('value'), 'HH:mm').format('HH:mm') + ':00';
            dateTimeChanged = hasFieldChanged(currentDateTime, originalAppointment.start_datetime);

            timezoneChanged = hasFieldChanged($selectTimezone.val(), originalCustomer.timezone);
        }

        $('#appointment-details').html(`
            <div>
                <div class="mb-2 fw-bold fs-4">
                    <u>${lang('service_and_provider')}</u>
                </div>
                <div class="mb-2 fw-bold ${getChangedFieldClass(serviceChanged)}">
                    <i class="fas fa-concierge-bell me-2"></i>
                    ${serviceOptionText}
                </div>
                <div class="mb-2 fw-bold ${getChangedFieldClass(providerChanged)}">
                    <i class="fas fa-user me-2"></i>
                    ${providerOptionText}
                </div>
                <div class="mb-2 ${getChangedFieldClass(dateTimeChanged)}">
                    <i class="fas fa-calendar-day me-2"></i>
                    ${formattedSelectedDate}
                </div>
                <div class="mb-2">
                    <i class="fas fa-clock me-2"></i>
                    ${service.duration} ${lang('minutes')}
                </div>
                <div class="mb-2" ${!Number(service.price) ? 'hidden' : ''}>
                    <i class="fas fa-cash-register me-2"></i>
                    ${getCurrencySymbol(service.currency)}${Number(service.price).toFixed(2)} ${service.currency}
                </div>
                <div class="mb-2">
                    <i class="fas fa-info-circle me-2"></i>
                    ${service.description}
                </div>
                <div class="mb-2">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    ${service.location}
                </div>
                <div class="mb-2 ${getChangedFieldClass(timezoneChanged)}">
                    <i class="fas fa-globe me-2"></i>
                    ${timezoneOptionText}
                </div>
            </div>
        `);

        // Render the customer information

        const firstName = App.Utils.String.escapeHtml($firstName.val());
        const lastName = App.Utils.String.escapeHtml($lastName.val());
        const fullName = `${firstName} ${lastName}`.trim();
        const email = App.Utils.String.escapeHtml($email.val());
        const mobilePhoneNumber = App.Utils.String.escapeHtml($mobilePhoneNumber.val());
        const workPhoneNumber = App.Utils.String.escapeHtml($workPhoneNumber.val());
        const address = App.Utils.String.escapeHtml($address.val());
        const city = App.Utils.String.escapeHtml($city.val());
        const state = App.Utils.String.escapeHtml($state.val());
        const zipCode = App.Utils.String.escapeHtml($zipCode.val());
        const notes = App.Utils.String.escapeHtml($notes.val());

        const customField1Value = $customField1.length ? App.Utils.String.escapeHtml($customField1.val()) : '';
        const customField2Value = $customField2.length ? App.Utils.String.escapeHtml($customField2.val()) : '';
        const customField3Value = $customField3.length ? App.Utils.String.escapeHtml($customField3.val()) : '';
        const customField4Value = $customField4.length ? App.Utils.String.escapeHtml($customField4.val()) : '';
        const customField5Value = $customField5.length ? App.Utils.String.escapeHtml($customField5.val()) : '';

        const customField1Name = $customField1.length ? $customField1.attr('name') : '';
        const customField2Name = $customField2.length ? $customField2.attr('name') : '';
        const customField3Name = $customField3.length ? $customField3.attr('name') : '';
        const customField4Name = $customField4.length ? $customField4.attr('name') : '';
        const customField5Name = $customField5.length ? $customField5.attr('name') : '';

        // Format the address properly when displaying
        const formattedAddress = (() => {
            const parts = [];
            if (city) parts.push(city);
            if (state) parts.push(state);
            const cityState = parts.join(', ');

            if (zipCode) {
                return cityState ? `${cityState} ${zipCode}` : zipCode;
            }
            return cityState;
        })();

        // Check for changes in customer data (if in manage mode)
        let nameChanged = false;
        let emailChanged = false;
        let mobileChanged = false;
        let workPhoneChanged = false;
        let addressChanged = false;
        let cityStateZipChanged = false;
        let notesChanged = false;
        let customField1Changed = false;
        let customField2Changed = false;
        let customField3Changed = false;
        let customField4Changed = false;
        let customField5Changed = false;

        if (manageMode) {
            const originalCustomer = vars('customer_data');
            const originalAppointment = vars('appointment_data');

            nameChanged = hasFieldChanged(firstName, originalCustomer.first_name) ||
                        hasFieldChanged(lastName, originalCustomer.last_name);
            emailChanged = hasFieldChanged(email, originalCustomer.email);
            mobileChanged = hasFieldChanged(mobilePhoneNumber, originalCustomer.mobile_phone_number);
            workPhoneChanged = hasFieldChanged(workPhoneNumber, originalCustomer.work_phone_number);
            addressChanged = hasFieldChanged(address, originalCustomer.address);

            // Check city/state/zip combination
            const originalFormattedAddress = (() => {
                const parts = [];
                if (originalCustomer.city) parts.push(originalCustomer.city);
                if (originalCustomer.state) parts.push(originalCustomer.state);
                const cityState = parts.join(', ');
                if (originalCustomer.zip_code) {
                    return cityState ? `${cityState} ${originalCustomer.zip_code}` : originalCustomer.zip_code;
                }
                return cityState;
            })();
            cityStateZipChanged = hasFieldChanged(formattedAddress, originalFormattedAddress);

            notesChanged = hasFieldChanged(notes, originalAppointment.notes);
            customField1Changed = hasFieldChanged(customField1Value, originalCustomer.custom_field_1);
            customField2Changed = hasFieldChanged(customField2Value, originalCustomer.custom_field_2);
            customField3Changed = hasFieldChanged(customField3Value, originalCustomer.custom_field_3);
            customField4Changed = hasFieldChanged(customField4Value, originalCustomer.custom_field_4);
            customField5Changed = hasFieldChanged(customField5Value, originalCustomer.custom_field_5);
        }

        $('#customer-details').html(`
            <div class="text-end">
                <div class="mb-2 fw-bold fs-4">
                    <u>${lang('customer')} ${' '} ${lang('contact_info')}</u>
                </div>
                <div class="mb-2 fw-bold ${getChangedFieldClass(nameChanged)} ${!nameChanged ? 'text-muted' : ''}" ${!fullName ? 'hidden' : ''}>
                    ${fullName}
                    <i class="fas fa-user me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(emailChanged)}" ${!email ? 'hidden' : ''}>
                    ${email}
                    <i class="fas fa-envelope me-2"></i>
                </div>
                <div class="mb-2  ${getChangedFieldClass(mobileChanged)}" ${!mobilePhoneNumber ? 'hidden' : ''}>
                    ${mobilePhoneNumber}
                    <i class="fas fa-phone me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(workPhoneChanged)}" ${!workPhoneNumber ? 'hidden' : ''}>
                    ${workPhoneNumber}
                    <i class="fas fa-phone me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(addressChanged)}" ${!address ? 'hidden' : ''}>
                    ${address}
                    <i class="fas fa-map-marker-alt me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(cityStateZipChanged)}" ${!formattedAddress ? 'hidden' : ''}>
                    ${formattedAddress}
                    <i class="fas fa-map-marker-alt me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(notesChanged)}" ${!notes.length ? 'hidden' : ''}>
                    Notes: ${notes}
                    <i class="fas fa-sticky-note me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(customField1Changed)}" ${!customField1Value.length ? 'hidden' : ''}>
                    ${customField1Name}: ${customField1Value}
                    <i class="fas fa-asterisk me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(customField2Changed)}" ${!customField2Value.length ? 'hidden' : ''}>
                    ${customField2Name}: ${customField2Value}
                    <i class="fas fa-asterisk me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(customField3Changed)}" ${!customField3Value.length ? 'hidden' : ''}>
                    ${customField3Name}: ${customField3Value}
                    <i class="fas fa-asterisk me-2"></i>
                </div>
                <div class="mb-2 ${getChangedFieldClass(customField4Changed)}" ${!customField4Value.length ? 'hidden' : ''}>
                    ${customField4Name}: ${customField4Value}
                    <i class="fas fa-asterisk me-2"></i>
                </div>
                <div class="mb-2  ${getChangedFieldClass(customField5Changed)}" ${!customField5Value.length ? 'hidden' : ''}>
                    ${customField5Name}: ${customField5Value}
                    <i class="fas fa-asterisk me-2"></i>
                </div>
            </div>
        `);

        // Update appointment form data for submission to server when the user confirms the appointment.

        const data = {};

        data.customer = {
            last_name: $lastName.val(),
            first_name: $firstName.val(),
            email: $email.val(),
            mobile_phone_number: $mobilePhoneNumber.val(),
            work_phone_number: $workPhoneNumber.val(),
            address: $address.val(),
            city: $city.val(),
            state: $state.val(),
            zip_code: $zipCode.val(),
            timezone: $selectTimezone.val(),
            custom_field_1: $customField1.val(),
            custom_field_2: $customField2.val(),
            custom_field_3: $customField3.val(),
            custom_field_4: $customField4.val(),
            custom_field_5: $customField5.val(),
        };

        data.appointment = {
            start_datetime:
                moment(App.Utils.UI.getDateTimePickerValue($selectDate)).format('YYYY-MM-DD') +
                ' ' +
                moment($('.selected-hour').data('value'), 'HH:mm').format('HH:mm') +
                ':00',
            end_datetime: calculateEndDatetime(),
            notes: $notes.val(),
            is_unavailability: false,
            id_users_provider: $selectProvider.val(),
            id_services: $selectService.val(),
        };

        data.manage_mode = Number(manageMode);

        if (manageMode) {
            data.appointment.id = vars('appointment_data').id;
            data.customer.id = vars('customer_data').id;
        }

        $('input[name="post_data"]').val(JSON.stringify(data));
    }

    /**
     * This method calculates the end datetime of the current appointment.
     *
     * End datetime is depending on the service and start datetime fields.
     *
     * @return {String} Returns the end datetime in string format.
     */
    function calculateEndDatetime() {
        // Find selected service duration.
        const serviceId = $selectService.val();

        const service = vars('available_services').find(
            (availableService) => Number(availableService.id) === Number(serviceId),
        );

        // Add the duration to the start datetime.
        const selectedDate = moment(App.Utils.UI.getDateTimePickerValue($selectDate)).format('YYYY-MM-DD');

        const selectedHour = $('.selected-hour').data('value'); // HH:mm

        const startMoment = moment(selectedDate + ' ' + selectedHour);

        let endMoment;

        if (service.duration && startMoment) {
            endMoment = startMoment.clone().add({'minutes': parseInt(service.duration)});
        } else {
            endMoment = moment();
        }

        return endMoment.format('YYYY-MM-DD HH:mm:ss');
    }

    /**
     * This method applies the appointment's data to the wizard so
     * that the user can start making changes on an existing record.
     *
     * @param {Object} appointment Selected appointment's data.
     * @param {Object} provider Selected provider's data.
     * @param {Object} customer Selected customer's data.
     *
     * @return {Boolean} Returns the operation result.
     */
    function applyAppointmentData(appointment, provider, customer) {
        try {
            // Select Service & Provider
            $selectService.val(appointment.id_services).trigger('change');
            $selectProvider.val(appointment.id_users_provider);

            // Set Appointment Date
            const startMoment = moment(appointment.start_datetime);
            App.Utils.UI.setDateTimePickerValue($selectDate, startMoment.toDate());
            App.Http.Booking.getAvailableHours(startMoment.format('YYYY-MM-DD'));

            // Apply Customer's Data
            $lastName.val(customer.last_name);
            $firstName.val(customer.first_name);
            $email.val(customer.email);
            $mobilePhoneNumber.val(customer.mobile_phone_number);
            $workPhoneNumber.val(customer.work_phone_number);
            $address.val(customer.address);
            $city.val(customer.city);
            $state.val(customer.state);
            $zipCode.val(customer.zip_code);
            if (customer.timezone) {
                $selectTimezone.val(customer.timezone);
            }
            const appointmentNotes = appointment.notes !== null ? appointment.notes : '';
            $notes.val(appointmentNotes);

            $customField1.val(customer.custom_field_1);
            $customField2.val(customer.custom_field_2);
            $customField3.val(customer.custom_field_3);
            $customField4.val(customer.custom_field_4);
            $customField5.val(customer.custom_field_5);

            App.Pages.Booking.updateConfirmFrame();

            return true;
        } catch (exc) {
            return false;
        }
    }

    /**
     * Update the service description and information.
     *
     * This method updates the HTML content with a brief description of the
     * user selected service (only if available in db). This is useful for the
     * customers upon selecting the correct service.
     *
     * @param {Number} serviceId The selected service record id.
     */
    function updateServiceDescription(serviceId) {
        const $serviceDescription = $('#service-description');

        $serviceDescription.empty();

        const service = vars('available_services').find(
            (availableService) => Number(availableService.id) === Number(serviceId),
        );

        if (!service) {
            return; // Service not found
        }

        // Render the additional service information

        const additionalInfoParts = [];

        if (service.duration) {
            additionalInfoParts.push(`${lang('duration')}: ${service.duration} ${lang('minutes')}`);
        }

        if (Number(service.price) > 0) {
            additionalInfoParts.push(`${lang('price')}: ${Number(service.price).toFixed(2)} ${service.currency}`);
        }

        if (service.location) {
            additionalInfoParts.push(`${lang('location')}: ${service.location}`);
        }

        if (additionalInfoParts.length) {
            $(`
                <div class="mb-2 fst-italic">
                    ${additionalInfoParts.join(', ')}
                </div>
            `).appendTo($serviceDescription);
        }

        // Render the service description

        if (service.description?.length) {
            const escapedDescription = App.Utils.String.escapeHtml(service.description);

            const multiLineDescription = escapedDescription.replaceAll('\n', '<br/>');

            $(`
                <div class="text-muted">
                    ${multiLineDescription}
                </div>
            `).appendTo($serviceDescription);
        }
    }

    /**
     * Get the currency symbol for a given currency code.
     * @param {string} currency
     * @returns {string}
     */
    function getCurrencySymbol(currency) {
        const symbols = {
            USD: '$',
            EUR: '€',
            GBP: '£',
            JPY: '¥',
            AUD: 'A$',
            CAD: 'C$',
            CHF: 'CHF',
            CNY: '¥',
            INR: '₹',
            RUB: '₽',
            // Add more as needed
        };
        return symbols[currency] || currency || '';
    }

    /**
    * Check if a field value has changed from its original value
    * @param {string|number|null|undefined} currentValue - Current form value
    * @param {string|number|null|undefined} originalValue - Original value from server data
    * @returns {boolean}
    */
    function hasFieldChanged(currentValue, originalValue) {
        // Handle null/undefined values by converting to empty string
        // Use nullish coalescing (??) instead of logical OR (||) to preserve falsy values like 0
        const current = currentValue ?? '';
        const original = originalValue ?? '';

        // Convert both to strings for consistent comparison
        return String(current) !== String(original);
    }

    /**
    * Get CSS class for changed fields in manage mode
    * @param {boolean} isChanged - Whether the field has changed
    * @returns {string}
    */
    function getChangedFieldClass(isChanged) {
        return manageMode && isChanged ? 'text-danger fw-bold' : '';
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {
        manageMode,
        updateConfirmFrame,
        updateServiceDescription,
        validateCustomerForm,
    };
})();
