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
 * Customers page.
 *
 * This module implements the functionality of the customers page.
 */
App.Pages.Customers = (function () {
    const $customersToolbar = $('#customers-toolbar');
    const $customers = $('#customers');
    const $filterCustomers = $('#filter-customers-form');
    const $id = $('#customer-id');
    const $firstName = $('#first-name');
    const $lastName = $('#last-name');
    const $email = $('#email');
    const $mobilePhoneNumber = $('#mobile-phone-number');
    const $workPhoneNumber = $('#work-phone-number');
    const $address = $('#address');
    const $city = $('#city');
    const $state = $('#state');
    const $zipCode = $('#zip-code');
    const $timezone = $('#timezone');
    const $language = $('#language');
    const $ldapDn = $('#ldap-dn');
    const $customField1 = $('#custom-field-1');
    const $customField2 = $('#custom-field-2');
    const $customField3 = $('#custom-field-3');
    const $customField4 = $('#custom-field-4');
    const $customField5 = $('#custom-field-5');
    const $notes = $('#notes');
    const $formMessage = $('#form-message');
    const $customerAppointments = $('#customer-appointments');

    const moment = window.moment;

    let filterResults = {};
    let filterLimit = 20;

    /**
     * Add the page event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Filter Customers Form "Submit"
         *
         * @param {jQuery.Event} event
         */
        $customersToolbar.on('submit', '#filter-customers-form', (event) => {
            event.preventDefault();
            const key = $filterCustomers.find('.key').val();
            $customers.find('.selected').removeClass('selected');
            filterLimit = 20;
            App.Pages.Customers.resetForm();
            App.Pages.Customers.filter(key);
        });

        /**
         * Event: Filter Entry "Click"
         *
         * Display the customer data of the selected row.
         *
         * @param {jQuery.Event} event
         */
        $customers.on('click', '.customer-row', (event) => {
            if ($filterCustomers.find('.filter').prop('disabled')) {
                return; // Do nothing when user edits a customer record.
            }

            const customerId = $(event.currentTarget).attr('data-id');
            const customer = filterResults.find((filterResult) => Number(filterResult.id) === Number(customerId));

            App.Pages.Customers.display(customer);
            $('#customers-list .selected').removeClass('selected');
            $(event.currentTarget).addClass('selected');
            $('#edit-customer, #delete-customer').prop('disabled', false);
        });

        /**
         * Event: Add Customer Button "Click"
         */
        $customersToolbar.on('click', '#add-customer', () => {
            App.Pages.Customers.resetForm();
            $customersToolbar.find('#add-edit-delete-group').hide();
            $customersToolbar.find('#save-cancel-group').show();
            $customers.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $customers.find('.record-details .form-label span').prop('hidden', false);
            $filterCustomers.find('button').prop('disabled', true);
            $customers.find('#customers-list').css('color', '#AAA');
        });

        /**
         * Event: Edit Customer Button "Click"
         */
        $customersToolbar.on('click', '#edit-customer', () => {
            $customersToolbar.find('#add-edit-delete-group').hide();
            $customersToolbar.find('#save-cancel-group').show();
            $customers.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $customers.find('.record-details .form-label span').prop('hidden', false);
            $filterCustomers.find('button').prop('disabled', true);
            $customers.find('#customers-list').css('color', '#AAA');
        });

        /**
         * Event: Cancel Customer Add/Edit Operation Button "Click"
         */
        $customersToolbar.on('click', '#cancel-customer', () => {
            const id = $id.val();

            App.Pages.Customers.resetForm();

            if (id) {
                select(id, true);
            }
        });

        /**
         * Event: Save Add/Edit Customer Operation "Click"
         */
        $customersToolbar.on('click', '#save-customer', () => {
            const customer = {
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
                timezone: $timezone.val(),
                language: $language.val() || 'english',
                custom_field_1: $customField1.val(),
                custom_field_2: $customField2.val(),
                custom_field_3: $customField3.val(),
                custom_field_4: $customField4.val(),
                custom_field_5: $customField5.val(),
                ldap_dn: $ldapDn.val(),
            };

            if ($id.val()) {
                customer.id = $id.val();
            }

            if (!App.Pages.Customers.validate()) {
                return;
            }

            App.Pages.Customers.save(customer);
        });

        /**
         * Event: Delete Customer Button "Click"
         */
        $customersToolbar.on('click', '#delete-customer', () => {
            const customerId = $id.val();
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
                        App.Pages.Customers.remove(customerId);
                        messageModal.hide();
                    },
                },
            ];

            App.Utils.Message.show(lang('delete_customer'), lang('delete_record_prompt'), buttons);
        });

        /**
         * Event: Clear Customers Button "Click"
         */
        $customersToolbar.on('click', '#clear-customers', () => {
            $filterCustomers.find('.key').val('');
            App.Pages.Customers.resetForm();
            App.Pages.Customers.filter('');
        });
    }

    /**
     * Save a customer record to the database (via ajax post).
     *
     * @param {Object} customer Contains the customer data.
     */
    function save(customer) {
        App.Http.Customers.save(customer).then((response) => {
            App.Layouts.Backend.displayNotification(lang('customer_saved'));
            App.Pages.Customers.resetForm();
            $('#filter-customers-form .key').val('');
            App.Pages.Customers.filter('', response.id, true);
        });
    }

    /**
     * Delete a customer record from database.
     *
     * @param {Number} id Record id to be deleted.
     */
    function remove(id) {
        App.Http.Customers.destroy(id).then(() => {
            App.Layouts.Backend.displayNotification(lang('customer_deleted'));
            App.Pages.Customers.resetForm();
            App.Pages.Customers.filter($('#filter-customers-form .key').val());
        });
    }

    /**
     * Validate customer data before save (insert or update).
     */
    function validate() {
        $formMessage.removeClass('alert-danger').hide();
        $('.is-invalid').removeClass('is-invalid');

        try {
            // Validate required fields.
            let missingRequired = false;

            $('.required').each((index, requiredField) => {
                if ($(requiredField).val() === '') {
                    $(requiredField).addClass('is-invalid');
                    missingRequired = true;
                }
            });

            if (missingRequired) {
                throw new Error(lang('fields_are_required'));
            }

            // Validate email address.
            const email = $email.val();

            if (email && !App.Utils.Validation.email(email)) {
                $email.addClass('is-invalid');
                throw new Error(lang('invalid_email'));
            }

            // Validate phone number.
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

            return true;
        } catch (error) {
            $formMessage.addClass('alert-danger').text(error.message).show();
            return false;
        }
    }

    /**
     * Bring the customer form back to its initial state.
     */
    function resetForm() {
        $customers.find('.record-details').find('input, select, textarea').val('').prop('disabled', true).addClass('disabled');
        $customers.find('.record-details .form-label span').prop('hidden', true);
        $customers.find('.record-details #timezone').val(vars('default_timezone'));
        $customers.find('.record-details #language').val(vars('default_language'));

        $customerAppointments.empty();

        $customersToolbar.find('#edit-customer, #delete-customer').prop('disabled', true);
        $customersToolbar.find('#add-edit-delete-group').show();
        $customersToolbar.find('#save-cancel-group').hide();

        $customers.find('.record-details .is-invalid').removeClass('is-invalid');
        $customers.find('.record-details #form-message').hide();

        $filterCustomers.find('button').prop('disabled', false);
        $customers.find('.selected').removeClass('selected');
        $customers.find('#customers-list').css('color', '');
    }

    /**
     * Display a customer record into the form.
     *
     * @param {Object} customer Contains the customer record data.
     */
    function display(customer) {
        $id.val(customer.id);
        $firstName.val(customer.first_name);
        $lastName.val(customer.last_name);
        $email.val(customer.email);
        $mobilePhoneNumber.val(customer.mobile_phone_number);
        $workPhoneNumber.val(customer.work_phone_number);
        $address.val(customer.address);
        $city.val(customer.city);
        $state.val(customer.state);
        $zipCode.val(customer.zip_code);
        $notes.val(customer.notes);
        $timezone.val(customer.timezone);
        $language.val(customer.language || 'english');
        $ldapDn.val(customer.ldap_dn);
        $customField1.val(customer.custom_field_1);
        $customField2.val(customer.custom_field_2);
        $customField3.val(customer.custom_field_3);
        $customField4.val(customer.custom_field_4);
        $customField5.val(customer.custom_field_5);

        $customerAppointments.empty();

        if (!customer.appointments.length) {
            $('<p/>', {
                'text': lang('no_records_found'),
            }).appendTo($customerAppointments);
        }

        customer.appointments.forEach((appointment) => {
            if (
                vars('role_slug') === App.Layouts.Backend.DB_SLUG_PROVIDER &&
                parseInt(appointment.id_users_provider) !== vars('user_id')
            ) {
                return;
            }

            if (
                vars('role_slug') === App.Layouts.Backend.DB_SLUG_SECRETARY &&
                vars('secretary_providers').indexOf(appointment.id_users_provider) === -1
            ) {
                return;
            }

            const start = App.Utils.Date.format(
                moment(appointment.start_datetime).toDate(),
                vars('date_format'),
                vars('time_format'),
                true,
            );

            const end = App.Utils.Date.format(
                moment(appointment.end_datetime).toDate(),
                vars('date_format'),
                vars('time_format'),
                true,
            );

            $('<div/>', {
                'class': 'appointment-row',
                'data-id': appointment.id,
                'html': [
                    // Service - Provider

                    $('<a/>', {
                        'href': App.Utils.Url.siteUrl(`calendar/reschedule/${appointment.hash}`),
                        'html': [
                            $('<i/>', {
                                'class': 'fas fa-edit me-1',
                            }),
                            $('<strong/>', {
                                'text':
                                    appointment.service.name +
                                    ' - ' +
                                    appointment.provider.first_name +
                                    ' ' +
                                    appointment.provider.last_name,
                            }),
                            $('<br/>'),
                        ],
                    }),

                    // Start

                    $('<small/>', {
                        'text': start,
                    }),
                    $('<br/>'),

                    // End

                    $('<small/>', {
                        'text': end,
                    }),
                    $('<br/>'),

                    // Timezone

                    $('<small/>', {
                        'text': vars('timezones')[appointment.provider.timezone],
                    }),
                ],
            }).appendTo('#customer-appointments');
        });
    }

    /**
     * Filter customer records.
     *
     * @param {String} keyword This keyword string is used to filter the customer records.
     * @param {Number} selectId Optional, if set then after the filter operation the record with the given
     * ID will be selected (but not displayed).
     * @param {Boolean} show Optional (false), if true then the selected record will be displayed on the form.
     */
    function filter(keyword, selectId = null, show = false) {
        App.Http.Customers.search(keyword, filterLimit).then((response) => {
            filterResults = response;

            $customers.find('#customers-list').empty();

            response.forEach((customer) => {
                $('#customers-list').append(App.Pages.Customers.getFilterHtml(customer)).append($('<hr/>'));
            });

            if (!response.length) {
                $customers.find('#customers-list').append(
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
                        App.Pages.Customers.filter(keyword, selectId, show);
                    },
                }).appendTo('#customers-list');
            }

            if (selectId) {
                App.Pages.Customers.select(selectId, show);
            }
        });
    }

    /**
     * Get the filter results row HTML code.
     *
     * @param {Object} customer Contains the customer data.
     *
     * @return {String} Returns the record HTML code.
     */
    function getFilterHtml(customer) {
        const name = (customer.first_name || '[No First Name]') + ' ' + (customer.last_name || '[No Last Name]');

        let info = customer.email || '[No Email]';

        info = customer.mobile_phone_number ? info + ', ' + customer.mobile_phone_number : info;

        return $('<div/>', {
            'class': 'customer-row entry',
            'data-id': customer.id,
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
     * Select a specific record from the current filter results.
     *
     * If the customer id does not exist in the list then no record will be selected.
     *
     * @param {Number} id The record id to be selected from the filter results.
     * @param {Boolean} show Optional (false), if true then the method will display the record on the form.
     */
    function select(id, show = false) {
        $('#customers-list .selected').removeClass('selected');

        $('#customers-list .entry[data-id="' + id + '"]').addClass('selected');

        if (show) {
            const customer = filterResults.find((filterResult) => Number(filterResult.id) === Number(id));

            App.Pages.Customers.display(customer);

            $('#edit-customer, #delete-customer').prop('disabled', false);
        }
    }

    /**
     * Initialize the module.
     */
    function initialize() {
        App.Pages.Customers.resetForm();
        App.Pages.Customers.addEventListeners();
        App.Pages.Customers.filter('');
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
