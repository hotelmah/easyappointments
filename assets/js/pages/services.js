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
 * Services page.
 *
 * This module implements the functionality of the services page.
 */
App.Pages.Services = (function () {
    const $servicesToolbar = $('#services-toolbar');
    const $services = $('#services');
    const $filterServices = $('#filter-services-form');
    const $id = $('#service-id');
    const $name = $('#name');
    const $duration = $('#duration');
    const $price = $('#price');
    const $currency = $('#currency');
    const $serviceCategoryId = $('#service-category-id');
    const $availabilitiesType = $('#availabilities-type');
    const $attendantsNumber = $('#attendants-number');
    const $location = $('#location');
    const $color = $('#color');
    const $isPrivate = $('#is-private');
    const $description = $('#description');
    let filterResults = {};
    let filterLimit = 20;

    /**
     * Add page event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Filter Services Form "Submit"
         *
         * @param {jQuery.Event} event
         */
        $servicesToolbar.on('submit', '#filter-services-form', (event) => {
            event.preventDefault();
            const key = $filterServices.find('.key').val();
            $services.find('.selected').removeClass('selected');
            App.Pages.Services.resetForm();
            App.Pages.Services.filter(key);
        });

        /**
         * Event: Filter Service Row "Click"
         *
         * Display the selected service data to the user.
         */
        $services.on('click', '.service-row', (event) => {
            if ($filterServices.find('.filter').prop('disabled')) {
                $services.find('#services-list').css('color', '#AAA');
                return; // exit because we are on edit mode
            }

            const serviceId = $(event.currentTarget).attr('data-id');
            const service = filterResults.find((filterResult) => Number(filterResult.id) === Number(serviceId));

            // Create booking links for the selected service
            createBookingLinks(service.id);

            $('#edit-service, #delete-service').prop('disabled', false);
            $services.find('.selected').removeClass('selected');
            $(event.currentTarget).addClass('selected');
            App.Pages.Services.display(service);
        });

        /**
         * Event: Add New Service Button "Click"
         */
        $servicesToolbar.on('click', '#add-service', () => {
            App.Pages.Services.resetForm();
            $servicesToolbar.find('#add-edit-delete-group').hide();
            $servicesToolbar.find('#save-cancel-group').show();
            $services.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $services.find('.record-details .form-label span').prop('hidden', false);
            $filterServices.find('button').prop('disabled', true);
            $services.find('#services-list').css('color', '#AAA');
            App.Components.ColorSelection.enable($color);

            // Default values
            // $name.val('Service');
            // $duration.val('30');
            // $price.val('0');
            $currency.val('');
            $serviceCategoryId.val('');
            $availabilitiesType.val('flexible');
            $attendantsNumber.val('1');
        });

        /**
         * Event: Cancel Service Button "Click"
         *
         * Cancel add or edit of a service record.
         */
        $servicesToolbar.on('click', '#cancel-service', () => {
            const id = $id.val();

            App.Pages.Services.resetForm();

            if (id !== '') {
                App.Pages.Services.select(id, true);
            }
        });

        /**
         * Event: Save Service Button "Click"
         */
        $servicesToolbar.on('click', '#save-service', () => {
            if (!App.Pages.Services.validate()) {
                return;
            }

            const service = {
                name: $name.val(),
                duration: $duration.val(),
                price: $price.val(),
                currency: $currency.val(),
                description: $description.val(),
                location: $location.val(),
                color: App.Components.ColorSelection.getColor($color),
                availabilities_type: $availabilitiesType.val(),
                attendants_number: $attendantsNumber.val(),
                is_private: Number($isPrivate.prop('checked')),
                id_service_categories: $serviceCategoryId.val() || undefined,
            };

            if ($id.val() !== '') {
                service.id = $id.val();
            }

            App.Pages.Services.save(service);
        });

        /**
         * Event: Edit Service Button "Click"
         */
        $servicesToolbar.on('click', '#edit-service', () => {
            $servicesToolbar.find('#add-edit-delete-group').hide();
            $servicesToolbar.find('#save-cancel-group').show();
            $services.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $services.find('.record-details .form-label span').prop('hidden', false);
            $filterServices.find('button').prop('disabled', true);
            $services.find('#services-list').css('color', '#AAA');
            App.Components.ColorSelection.enable($color);
        });

        /**
         * Event: Delete Service Button "Click"
         */
        $servicesToolbar.on('click', '#delete-service', () => {
            const serviceId = $id.val();
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
                        App.Pages.Services.remove(serviceId);
                        messageModal.hide();
                    },
                },
            ];

            App.Utils.Message.show(lang('delete_service'), lang('delete_record_prompt'), buttons);
        });

        /**
         * Event: Clear Services Button "Click"
         */
        $servicesToolbar.on('click', '#clear-services', () => {
            $filterServices.find('.key').val('');
            App.Pages.Services.resetForm();
            App.Pages.Services.filter('');
        });
    }

    /**
     * Save service record to database.
     *
     * @param {Object} service Contains the service record data. If an 'id' value is provided
     * then the update operation is going to be executed.
     */
    function save(service) {
        App.Http.Services.save(service).then((response) => {
            App.Layouts.Backend.displayNotification(lang('service_saved'));
            App.Pages.Services.resetForm();
            $filterServices.find('.key').val('');
            App.Pages.Services.filter('', response.id, true);
        });
    }

    /**
     * Delete a service record from database.
     *
     * @param {Number} id Record ID to be deleted.
     */
    function remove(id) {
        App.Http.Services.destroy(id).then(() => {
            App.Layouts.Backend.displayNotification(lang('service_deleted'));
            App.Pages.Services.resetForm();
            App.Pages.Services.filter($filterServices.find('.key').val());
        });
    }

    /**
     * Validates a service record.
     *
     * @return {Boolean} Returns the validation result.
     */
    function validate() {
        $services.find('.is-invalid').removeClass('is-invalid').addClass('border-primary');

        try {
            // Validate required fields.
            let missingRequired = false;

            if ($price.val() === '') {
                $price.val('0.00');
            }

            $services.find('.required').each((index, requiredField) => {
                if (!$(requiredField).val()) {
                    $(requiredField).removeClass('border border-primary');
                    $(requiredField).addClass('is-invalid');
                    missingRequired = true;

                    // Get all attributes of the required field, for testing
                    const attributes = {};
                    $.each(requiredField.attributes, function () {
                        attributes[this.name] = this.value;
                    });
                }
            });

            // Validate the duration.
            if (Number($duration.val()) < vars('event_minimum_duration')) {
                $duration.addClass('is-invalid').removeClass('border border-primary');
                throw new Error(lang('invalid_duration'));
            }

            if (!Number($price.val()) && ($price.val() !== '0.00')) {
                $price.addClass('is-invalid').removeClass('border border-primary');
                throw new Error(lang('invalid_price'));
            }

            // Format price to 2 decimal places if valid number
            const priceValue = parseFloat($price.val());
            if (!isNaN(priceValue)) {
                $price.val(priceValue.toFixed(2));
            }

            // Validate currency: only 3 alphabetic characters, no numbers
            const currencyValue = $currency.val().toUpperCase();
            $currency.val(currencyValue);

            if (!/^[A-Za-z]{3}$/.test(currencyValue)) {
                $currency.addClass('is-invalid').removeClass('border border-primary');
                throw new Error(lang('invalid_currency'));
            }

            if (missingRequired) {
                throw new Error(lang('fields_are_required'));
            }

            return true;
        } catch (error) {
            App.Utils.Validation.showFormFieldAlert(error.message);
            return false;
        }
    }

    /**
     * Resets the service tab form back to its initial state.
     */
    function resetForm() {
        $services.find('.selected').removeClass('selected');
        $filterServices.find('button').prop('disabled', false);
        $services.find('#services-list').css('color', '');

        $services.find('.record-details').find('input, select, textarea').val('').prop('disabled', true).addClass('disabled');
        $services.find('.record-details .form-label span').prop('hidden', true);
        $services.find('.record-details #is-private').prop('checked', false);
        $services.find('.record-details h4 a').remove();

        $servicesToolbar.find('#add-edit-delete-group').show();
        $servicesToolbar.find('#save-cancel-group').hide();
        $('#edit-service, #delete-service').prop('disabled', true);

        $services.find('.record-details .is-invalid').removeClass('is-invalid').addClass('border border-primary');

        App.Components.ColorSelection.disable($color);
    }

    /**
     * Display a service record into the service form.
     *
     * @param {Object} service Contains the service record data.
     */
    function display(service) {
        $id.val(service.id);
        $name.val(service.name);
        $duration.val(service.duration);

        // Format price to 2 decimal places if valid number
        const priceValue = parseFloat(service.price);
        if (!isNaN(priceValue)) {
            $price.val(priceValue.toFixed(2));
        }

        $currency.val(service.currency);
        $description.val(service.description);
        $location.val(service.location);
        $availabilitiesType.val(service.availabilities_type);
        $attendantsNumber.val(service.attendants_number);
        $isPrivate.prop('checked', service.is_private);
        App.Components.ColorSelection.setColor($color, service.color);

        const serviceCategoryId = service.id_service_categories !== null ? service.id_service_categories : '';
        $serviceCategoryId.val(serviceCategoryId);
    }

    /**
     * Filters service records depending on a string keyword.
     *
     * @param {String} keyword This is used to filter the service records of the database.
     * @param {Number} selectId Optional, if set then after the filter operation the record with this
     * ID will be selected (but not displayed).
     * @param {Boolean} show Optional (false), if true then the selected record will be displayed on the form.
     */
    function filter(keyword, selectId = null, show = false) {
        App.Http.Services.search(keyword, filterLimit).then((response) => {
            filterResults = response;

            $services.find('#services-list').empty();

            response.forEach((service) => {
                $services.find('#services-list').append(App.Pages.Services.getFilterHtml(service)).append($('<hr/>'));
            });

            if (response.length === 0) {
                $services.find('#services-list').append(
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
                        App.Pages.Services.filter(keyword, selectId, show);
                    },
                }).appendTo('#services-list');
            }

            if (selectId) {
                App.Pages.Services.select(selectId, show);
            }
        });
    }

    /**
     * Get Filter HTML
     *
     * Get a service row HTML code that is going to be displayed on the filter results list.
     *
     * @param {Object} service Contains the service record data.
     *
     * @return {String} The HTML code that represents the record on the filter results list.
     */
    function getFilterHtml(service) {
        const name = service.name;

        const info = service.duration + ' minutes, ' + App.Utils.Currency.formatServicePrice(service.price, service.currency) + ' ' + service.currency;

        return $('<div/>', {
            'class': 'service-row entry',
            'data-id': service.id,
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
     * Select a specific record from the current filter results. If the service id does not exist
     * in the list then no record will be selected.
     *
     * @param {Number} id The record id to be selected from the filter results.
     * @param {Boolean} show Optional (false), if true then the method will display the record on the form.
     */
    function select(id, show = false) {
        $services.find('.selected').removeClass('selected');

        $services.find('.service-row[data-id="' + id + '"]').addClass('selected');

        if (show) {
            const service = filterResults.find((filterResult) => Number(filterResult.id) === Number(id));

            App.Pages.Services.display(service);

            $('#edit-service, #delete-service').prop('disabled', false);

            createBookingLinks(id);
        }
    }

    /**
     * Update the service-category list box.
     *
     * Use this method every time a change is made to the service categories db table.
     */
    function updateAvailableServiceCategories() {
        App.Http.ServiceCategories.search('', 999).then((response) => {
            $serviceCategoryId.empty();

            $serviceCategoryId.append(new Option('', '')).val('');

            response.forEach((serviceCategory) => {
                $serviceCategoryId.append(new Option(serviceCategory.name, serviceCategory.id));
            });
        });
    }

    /**
    * Create and display booking link and copy button for a service next to details heading
    *
    * @param {Number} service_id - The service ID
    */
    function createBookingLinks(service_id) {
        // Add dedicated provider link.
        const dedicatedUrl = App.Utils.Url.siteUrl('?service=' + encodeURIComponent(service_id));

        const $link = $('<a/>', {
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

        $services.find('.record-details h4').find('a, button').remove().end().append($link).append($copyButton);

        // Add click event to copy button in service row click handler
        $copyButton.on('click', function(e) {
            e.preventDefault();
            const urlToCopy = $(this).data('url');
            App.Utils.Copy.copyToClipboard(urlToCopy, $(this));
        });
    }

    /**
     * Initialize the module.
     */
    function initialize() {
        App.Pages.Services.resetForm();
        App.Pages.Services.filter('');
        App.Pages.Services.addEventListeners();
        updateAvailableServiceCategories();
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
