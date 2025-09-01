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
 * Providers page.
 *
 * This module implements the functionality of the providers page.
 */
App.Pages.Providers = (function () {
    const $providersToolbar = $('#providers-toolbar');
    const $providers = $('#providers');
    const $id = $('#provider-id');
    const $firstName = $('#first-name');
    const $lastName = $('#last-name');
    const $email = $('#email');
    const $mobilePhoneNumber = $('#mobile-phone-number');
    const $workPhoneNumber = $('#work-phone-number');
    const $address = $('#address');
    const $city = $('#city');
    const $state = $('#state');
    const $zipCode = $('#zip-code');
    const $isPrivate = $('#is-private');
    const $notes = $('#notes');
    const $language = $('#language');
    const $timezone = $('#timezone');
    const $ldapDn = $('#ldap-dn');
    const $username = $('#username');
    const $password = $('#password');
    const $passwordConfirmation = $('#password-confirm');
    const $notifications = $('#notifications');
    const $calendarView = $('#calendar-view');
    const $filterProviders = $('#providers-filter');
    let filterResults = {};
    let filterLimit = 20;
    let workingPlanManager;

    /**
     * Add the page event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Filter Providers Form "Submit"
         *
         * Filter the provider records with the given key string.
         *
         * @param {jQuery.Event} event
         */
        $providersToolbar.on('submit', '#filter-providers-form', (event) => {
            event.preventDefault();
            const key = $('#providers-filter .key').val();
            $('.selected').removeClass('selected');
            App.Pages.Providers.resetForm();
            App.Pages.Providers.filter(key);
        });

        /**
         * Event: Filter Provider Row "Click"
         *
         * Display the selected provider data to the user.
         */
        $providers.on('click', '.provider-row', (event) => {
            if ($filterProviders.find('.filter').prop('disabled')) {
                $providers.find('#providers-list').css('color', '#AAA');
                return; // Exit because we are currently on edit mode.
            }

            const providerId = $(event.currentTarget).attr('data-id');
            const provider = filterResults.find((filterResult) => Number(filterResult.id) === Number(providerId));

            $('#edit-provider, #delete-provider').prop('disabled', false);
            $providers.find('.selected').removeClass('selected');
            $(event.currentTarget).addClass('selected');
            App.Pages.Providers.display(provider);
        });

        /**
         * Event: Add New Provider Button "Click"
         */
        $providersToolbar.on('click', '#add-provider', () => {
            App.Pages.Providers.resetForm();

            $providersToolbar.find('#add-edit-delete-group').hide();
            $providersToolbar.find('#save-cancel-group').show();

            $providers.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $providers.find('.record-details .form-label span').prop('hidden', false);
            $filterProviders.find('button').prop('disabled', true);
            $providers.find('#providers-list').css('color', '#AAA');

            // $('#password, #password-confirm').addClass('required');

            $providers
                .find(
                    '.add-break, .edit-break, .delete-break, .add-working-plan-exception, .edit-working-plan-exception, .delete-working-plan-exception, #reset-working-plan',
                )
                .prop('disabled', false);
            $('#provider-services input:checkbox').prop('disabled', false);

            // Apply default working plan
            const companyWorkingPlan = JSON.parse(vars('company_working_plan'));
            workingPlanManager.setup(companyWorkingPlan);
            workingPlanManager.timepickers(false);
        });

        /**
         * Event: Edit Provider Button "Click"
         */
        $providersToolbar.on('click', '#edit-provider', () => {
            $providersToolbar.find('#add-edit-delete-group').hide();
            $providersToolbar.find('#save-cancel-group').show();

            $providers.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $providers.find('.record-details .form-label span').prop('hidden', false);
            $filterProviders.find('button').prop('disabled', true);
            $providers.find('#providers-list').css('color', '#AAA');

            $('#password, #password-confirm').removeClass('required').parent().find('.text-danger').remove();
            $('#provider-services input:checkbox').prop('disabled', false);
            $providers
                .find(
                    '.add-break, .edit-break, .delete-break, .add-working-plan-exception, .edit-working-plan-exception, .delete-working-plan-exception, #reset-working-plan',
                )
                .prop('disabled', false);
            $('#providers input:checkbox').prop('disabled', false);
            workingPlanManager.timepickers(false);
        });

        /**
         * Event: Delete Provider Button "Click"
         */
        $providersToolbar.on('click', '#delete-provider', () => {
            const providerId = $id.val();

            const buttons = [
                {
                    text: lang('cancel'),
                    click: (event, messageModal) => {
                        messageModal.hide();
                    },
                },
                {
                    text: lang('delete'),
                    click: (event, messageModal) => {
                        App.Pages.Providers.remove(providerId);
                        messageModal.hide();
                    },
                },
            ];

            App.Utils.Message.show(lang('delete_provider'), lang('delete_record_prompt'), buttons);
        });

        /**
         * Event: Save Provider Button "Click"
         */
        $providersToolbar.on('click', '#save-provider', () => {
            if (!App.Pages.Providers.validate()) {
                return;
            }

            const provider = {
                first_name: $firstName.val(),
                last_name: $lastName.val(),
                email: $email.val(),
                mobile_phone_number: $mobilePhoneNumber.val(),
                work_phone_number: $workPhoneNumber.val(),
                address: $address.val(),
                city: $city.val(),
                state: $state.val(),
                zip_code: $zipCode.val(),
                is_private: Number($isPrivate.prop('checked')),
                notes: $notes.val(),
                language: $language.val(),
                timezone: $timezone.val(),
                ldap_dn: $ldapDn.val(),
                settings: {
                    username: $username.val(),
                    working_plan: JSON.stringify(workingPlanManager.get()),
                    working_plan_exceptions: JSON.stringify(workingPlanManager.getWorkingPlanExceptions()),
                    notifications: Number($notifications.prop('checked')),
                    calendar_view: $calendarView.val(),
                },
            };

            // Include provider services.
            provider.services = [];
            $('#provider-services input:checkbox').each((index, checkboxEl) => {
                if ($(checkboxEl).prop('checked')) {
                    provider.services.push($(checkboxEl).attr('data-id'));
                }
            });

            // Include password if changed.
            if ($password.val() !== '') {
                provider.settings.password = $password.val();
            }

            // Include id if changed.
            if ($id.val() !== '') {
                provider.id = $id.val();
            }

            App.Pages.Providers.save(provider);
        });

        /**
         * Event: Cancel Provider Button "Click"
         *
         * Cancel add or edit of an provider record.
         */
        $providersToolbar.on('click', '#cancel-provider', () => {
            const id = $('#providers-list .selected').attr('data-id');

            App.Pages.Providers.resetForm();
            if (id) {
                App.Pages.Providers.select(id, true);
            }
        });

        /**
         * Event: Reset Working Plan Button "Click".
         */
        $providersToolbar.on('click', '#reset-working-plan', () => {
            $('.breaks tbody').empty();
            $('.working-plan-exceptions tbody').empty();
            $('.work-start, .work-end').val('');
            const companyWorkingPlan = JSON.parse(vars('company_working_plan'));
            workingPlanManager.setup(companyWorkingPlan);
            workingPlanManager.timepickers(false);
        });

        /**
         * Event: Clear Providers Button "Click"
         */
        $providersToolbar.on('click', '#clear-providers', () => {
            $filterProviders.find('.key').val('');
            App.Pages.Providers.resetForm();
            App.Pages.Providers.filter('');
        });
    }

    /**
     * Save provider record to database.
     *
     * @param {Object} provider Contains the provider record data. If an 'id' value is provided
     * then the update operation is going to be executed.
     */
    function save(provider) {
        App.Http.Providers.save(provider).then((response) => {
            App.Layouts.Backend.displayNotification(lang('provider_saved'));
            App.Pages.Providers.resetForm();
            $('#filter-providers .key').val('');
            App.Pages.Providers.filter('', response.id, true);
        });
    }

    /**
     * Delete a provider record from database.
     *
     * @param {Number} id Record id to be deleted.
     */
    function remove(id) {
        App.Http.Providers.destroy(id).then(() => {
            App.Layouts.Backend.displayNotification(lang('provider_deleted'));
            App.Pages.Providers.resetForm();
            App.Pages.Providers.filter($('#filter-providers .key').val());
        });
    }

    /**
     * Validates a provider record.
     *
     * @return {Boolean} Returns the validation result.
     */
    function validate() {
        $providers.find('.is-invalid').removeClass('is-invalid');
        $providers.find('.form-message').removeClass('alert-danger').hide();

        try {
            // Validate required fields.
            let missingRequired = false;

            // Validate passwords.
            if ($password.val() !== $passwordConfirmation.val()) {
                $('#password, #password-confirm').addClass('is-invalid');
                throw new Error(lang('passwords_mismatch'));
            }

            if ($password.val().length < vars('min_password_length') && $password.val() !== '') {
                $('#password, #password-confirm').addClass('is-invalid');
                throw new Error(lang('password_length_notice').replace('$number', vars('min_password_length')));
            }

            // Validate user email.
            if (!App.Utils.Validation.email($email.val())) {
                $email.addClass('is-invalid');
                throw new Error(lang('invalid_email'));
            }

            // Validate phone number.
            const workPhoneNumber = $workPhoneNumber.val();

            if (workPhoneNumber && !App.Utils.Validation.isValidUSTelephone(workPhoneNumber)) {
                $workPhoneNumber.addClass('is-invalid');
                throw new Error(lang('invalid_phone'));
            }

            // Validate mobile number.
            const mobileNumber = $mobilePhoneNumber.val();

            if (mobileNumber && !App.Utils.Validation.isValidUSTelephone(mobileNumber)) {
                $mobilePhoneNumber.addClass('is-invalid');
                throw new Error(lang('invalid_phone'));
            }

            // Check if username exists
            if ($username.attr('already-exists') === 'true') {
                $username.addClass('is-invalid');
                throw new Error(lang('username_already_exists'));
            }

            $providers.find('.required').each((index, requiredFieldEl) => {
                if (!$(requiredFieldEl).val()) {
                    $(requiredFieldEl).addClass('is-invalid');
                    missingRequired = true;
                }
            });

            if (missingRequired) {
                throw new Error(lang('fields_are_required'));
            }

            return true;
        } catch (error) {
            $('#providers .form-message').addClass('alert-danger').text(error.message).show();
            return false;
        }
    }

    /**
     * Resets the provider tab form back to its initial state.
     */
    function resetForm() {
        $providers.find('.selected').removeClass('selected');
        $filterProviders.find('button').prop('disabled', false);
        $providers.find('#providers-list').css('color', '');

        $providers.find('.record-details').find('input, select, textarea').val('').prop('disabled', true).addClass('disabled');
        $providers.find('.record-details .form-label span').prop('hidden', true);
        $providers.find('.record-details #calendar-view').val('default');
        $providers.find('.record-details #language').val(vars('default_language'));
        $providers.find('.record-details #timezone').val(vars('default_timezone'));
        $providers.find('.record-details #is-private').prop('checked', false);
        $providers.find('.record-details #notifications').prop('checked', true).prop('readonly', true);
        $providers.find('.add-break, .add-working-plan-exception, #reset-working-plan').prop('disabled', true);
        $providers.find('.record-details h4 a').remove();

        $providersToolbar.find('#add-edit-delete-group').show();
        $providersToolbar.find('#save-cancel-group').hide();

        workingPlanManager.timepickers(true);
        $providers.find('#providers .working-plan input:checkbox').prop('disabled', true);
        $('.breaks').find('.edit-break, .delete-break').prop('disabled', true);
        $('.working-plan-exceptions')
            .find('.edit-working-plan-exception, .delete-working-plan-exception')
            .prop('disabled', true);

        $providers.find('.record-details .is-invalid').removeClass('is-invalid').addClass('border border-primary');
        // $providers.find('.record-details .form-message').hide();

        $('#edit-provider, #delete-provider').prop('disabled', true);

        $('#provider-services').empty();
        populateProviderServices();
        $('#provider-services input:checkbox').prop('disabled', true);

        $('#providers .working-plan tbody').empty();
        $('#providers .breaks tbody').empty();
        $('#providers .working-plan-exceptions tbody').empty();
    }

    /**
     * Display a provider record into the provider form.
     *
     * @param {Object} provider Contains the provider record data.
     */
    function display(provider) {
        $id.val(provider.id);
        $firstName.val(provider.first_name);
        $lastName.val(provider.last_name);
        $email.val(provider.email);
        $mobilePhoneNumber.val(provider.mobile_phone_number);
        $workPhoneNumber.val(provider.work_phone_number);
        $address.val(provider.address);
        $city.val(provider.city);
        $state.val(provider.state);
        $zipCode.val(provider.zip_code);
        $isPrivate.prop('checked', provider.is_private);
        $notes.val(provider.notes);
        $language.val(provider.language);
        $timezone.val(provider.timezone);
        $ldapDn.val(provider.ldap_dn);

        $username.val(provider.settings.username);
        $calendarView.val(provider.settings.calendar_view);
        $notifications.prop('checked', Boolean(Number(provider.settings.notifications))).toggleClass('checked-state', Boolean(Number(provider.settings.notifications)));

        // Add dedicated provider link.
        let dedicatedUrl = App.Utils.Url.siteUrl('?provider=' + encodeURIComponent(provider.id));
        let $link = $('<a/>', {
            'href': dedicatedUrl,
            'id': 'booking-link-specific',
            'target': '_blank',
            'class': 'badge bg-info text-decoration-none ps-2', // Add Bootstrap badge classes
            'title': lang('booking_link_specific'),
            'data-tippy-content': lang('booking_link_specific'),
            'html': [
                $('<i/>', {
                    'class': 'fas fa-link me-2',
                }),

                $('<span/>', {
                    'text': lang('booking_link'),
                }),
            ],
        });

        // Create copy button
        const $copyButton = $('<a/>', {
            'id': 'booking-link-specific-copy',
            'class': 'badge bg-dark text-decoration-none text-light ms-2',
            'title': lang('copy_link'),
            'data-tippy-content': lang('copy_link'),
            'data-url': dedicatedUrl, // Store URL in data attribute
            'html': [
                $('<i/>', {
                    'class': 'fas fa-copy me-1',
                }),
                $('<span/>', {
                    'text': lang('copy'),
                }),
            ],
        });

        $providers.find('.details-view h4').find('a, button').remove().end().append($link).append($copyButton);

        // Add click event to copy button in service row click handler
        $copyButton.on('click', function(e) {
            e.preventDefault();
            const urlToCopy = $(this).data('url');
            App.Utils.Copy.copyToClipboard(urlToCopy, $(this));
        });

        // $('#provider-services a').remove();
        // $('#provider-services input:checkbox').prop('checked', false);

        $('#provider-services').empty();
        populateProviderServices();

        provider.services.forEach((providerServiceId) => {
            const $checkbox = $('#provider-services input[data-id="' + providerServiceId + '"]');

            if (!$checkbox.length) {
                return;
            }

            $checkbox.prop('checked', true);

            // Add dedicated service-provider link.
            dedicatedUrl = App.Utils.Url.siteUrl(
                '?provider=' + encodeURIComponent(provider.id) + '&service=' + encodeURIComponent(providerServiceId),
            );

            $link = $('<a/>', {
                'href': dedicatedUrl,
                'target': '_blank',
                'class': 'badge bg-info text-decoration-none ps-2 w-50 booking-link-specific', // Add Bootstrap badge classes
                'html': [
                    $('<i/>', {
                        'class': 'fas fa-link me-2',
                    }),

                    $('<span/>', {
                        'text': lang('booking_link'),
                    }),
                ],
            });

            $checkbox.parent().append($link);
        });

        // Display working plan
        const workingPlan = JSON.parse(provider.settings.working_plan);
        workingPlanManager.setup(workingPlan);
        $('.working-plan').find('input').prop('disabled', true);
        $('.breaks').find('.edit-break, .delete-break').prop('disabled', true);

        $providers.find('.working-plan-exceptions tbody').empty();
        const workingPlanExceptions = JSON.parse(provider.settings.working_plan_exceptions);
        workingPlanManager.setupWorkingPlanExceptions(workingPlanExceptions);
        $('.working-plan-exceptions')
            .find('.edit-working-plan-exception, .delete-working-plan-exception')
            .prop('disabled', true);
        $providers.find('.working-plan input:checkbox').prop('disabled', true);
    }

    /**
     * Filters provider records depending a string keyword.
     *
     * @param {string} keyword This is used to filter the provider records of the database.
     * @param {numeric} selectId Optional, if set, when the function is complete a result row can be set as selected.
     * @param {bool} show Optional (false), if true the selected record will be also displayed.
     */
    function filter(keyword, selectId = null, show = false) {
        App.Http.Providers.search(keyword, filterLimit).then((response) => {
            filterResults = response;

            $providers.find('#providers-list').empty();
            response.forEach((provider) => {
                $providers.find('#providers-list').append(App.Pages.Providers.getFilterHtml(provider)).append($('<hr/>'));
            });

            if (!response.length) {
                $providers.find('#providers-list').append(
                    $('<em/>', {
                        'text': lang('no_records_found'),
                    }),
                );
            } else if (response.length === filterLimit) {
                $('<button/>', {
                    'type': 'button',
                    'class': 'btn btn-outline-secondary w-100 load-more text-center',
                    'text': lang('load_more'),
                    'click': () => {
                        filterLimit += 20;
                        App.Pages.Providers.filter(keyword, selectId, show);
                    },
                }).appendTo('#providers-list');
            }

            // Initialize Tippy tooltips for provider rows
            if (window.tippy) {
                tippy('.provider-row[data-tippy-content]', {
                    placement: 'top',
                    theme: 'light-border',
                });
            }

            if (selectId) {
                App.Pages.Providers.select(selectId, show);
            }
        });
    }

    /**
     * Get an provider row html code that is going to be displayed on the filter results list.
     *
     * @param {Object} provider Contains the provider record data.
     *
     * @return {String} The html code that represents the record on the filter results list.
     */
    function getFilterHtml(provider) {
        const name = provider.first_name + ' ' + provider.last_name;

        let info = provider.email;

        info = provider.mobile_phone_number ? info + ', ' + provider.mobile_phone_number : info;

        info = provider.work_phone_number ? info + ', ' + provider.work_phone_number : info;

        return $('<div/>', {
            'class': 'provider-row entry',
            'data-id': provider.id,
            'data-tippy-content': info,
            'html': [
                $('<strong/>', {
                    'text': name,
                }),
                $('<br/>'),
                $('<small/>', {
                    'class': 'text-muted',
                    'text': info,
                }),
                $('<br/>'),
            ],
        });
    }

    /**
     * Select and display a providers filter result on the form.
     *
     * @param {Number} id Record id to be selected.
     * @param {Boolean} show Optional (false), if true the record will be displayed on the form.
     */
    function select(id, show = false) {
        // Select record in filter results.
        $providers.find('.provider-row[data-id="' + id + '"]').addClass('selected');

        // Display record in form (if display = true).
        if (show) {
            const provider = filterResults.find((filterResult) => Number(filterResult.id) === Number(id));

            App.Pages.Providers.display(provider);

            $('#edit-provider, #delete-provider').prop('disabled', false);
        }
    }

    function populateProviderServices() {
        vars('services').forEach((service) => {
            const checkboxId = `provider-service-${service.id}`;

            $('<div/>', {
                'class': 'checkbox',
                'html': [
                    $('<div/>', {
                        'class': 'checkbox form-check',
                        'html': [
                            $('<input/>', {
                                'id': checkboxId,
                                'class': 'form-check-input border border-primary',
                                'type': 'checkbox',
                                'data-id': service.id,
                                'prop': {
                                    'disabled': true,
                                },
                            }),
                            $('<label/>', {
                                'class': 'form-check-label',
                                'text': service.name,
                                'for': checkboxId,
                            }),
                        ],
                    }),
                ],
            }).appendTo('#provider-services');
        });
    }


    /**
     * Initialize the module.
     */
    function initialize() {
        workingPlanManager = new App.Utils.WorkingPlan();
        workingPlanManager.addEventListeners();

        App.Pages.Providers.resetForm();
        App.Pages.Providers.filter('');
        App.Pages.Providers.addEventListeners();

        // Initialize Bootstrap tabs manually if needed
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabLinks.forEach(tab => {
            new bootstrap.Tab(tab);
        });
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {
        filter,
        save,
        remove,
        validate,
        getFilterHtml,
        resetForm,
        display,
        select,
        addEventListeners,
    };
})();
