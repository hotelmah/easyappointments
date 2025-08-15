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
 * Service-categories page.
 *
 * This module implements the functionality of the service-categories page.
 */
App.Pages.ServiceCategories = (function () {
    const $servicesCategoriesToolbar = $('#service-categories-toolbar');
    const $serviceCategories = $('#service-categories');
    const $filterServiceCategories = $('#filter-service-categories-form');
    const $id = $('#service-category-id');
    const $name = $('#name');
    const $description = $('#description');
    let filterResults = {};
    let filterLimit = 20;

    /**
     * Add the page event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Filter Service-Categories Form "Submit"
         *
         * @param {jQuery.Event} event
         */
        $servicesCategoriesToolbar.on('submit', '#filter-service-categories-form', (event) => {
            event.preventDefault();
            const key = $('#filter-service-categories-form .key').val();
            $('.selected').removeClass('selected');
            App.Pages.ServiceCategories.resetForm();
            App.Pages.ServiceCategories.filter(key);
        });

        /**
         * Event: Filter Service-Categories Row "Click"
         *
         * Displays the selected row data on the right side of the page.
         *
         * @param {jQuery.Event} event
         */
        $serviceCategories.on('click', '.service-category-row', (event) => {
            if ($('#filter-service-categories-form .filter').prop('disabled')) {
                $serviceCategories.find('#service-categories-list').css('color', '#AAA');
                return; // exit because we are on edit mode
            }

            const serviceCategoryId = $(event.currentTarget).attr('data-id');
            const serviceCategory = filterResults.find((filterResult) => Number(filterResult.id) === Number(serviceCategoryId));

            $('#edit-service-category, #delete-service-category').prop('disabled', false);
            $serviceCategories.find('.selected').removeClass('selected');
            $(event.currentTarget).addClass('selected');
            App.Pages.ServiceCategories.display(serviceCategory);
        });

        /**
         * Event: Add Service-Category Button "Click"
         */
        $servicesCategoriesToolbar.on('click', '#add-service-category', () => {
            App.Pages.ServiceCategories.resetForm();
            $servicesCategoriesToolbar.find('#add-edit-delete-group').hide();
            $servicesCategoriesToolbar.find('#save-cancel-group').show();
            $serviceCategories.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $serviceCategories.find('.record-details .form-label span').prop('hidden', false);
            $filterServiceCategories.find('button').prop('disabled', true);
            $serviceCategories.find('#service-categories-list').css('color', '#AAA');
        });

        /**
         * Event: Edit Service-Category Button "Click"
         */
        $servicesCategoriesToolbar.on('click', '#edit-service-category', () => {
            $servicesCategoriesToolbar.find('#add-edit-delete-group').hide();
            $servicesCategoriesToolbar.find('#save-cancel-group').show();
            $serviceCategories.find('.record-details').find('input, select, textarea').prop('disabled', false).removeClass('disabled');
            $serviceCategories.find('.record-details .form-label span').prop('hidden', false);
            $filterServiceCategories.find('button').prop('disabled', true);
            $serviceCategories.find('#service-categories-list').css('color', '#AAA');
        });

        /**
         * Event: Delete Service-Category Button "Click"
         */
        $servicesCategoriesToolbar.on('click', '#delete-service-category', () => {
            const serviceCategoryId = $id.val();

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
                        remove(serviceCategoryId);
                        messageModal.hide();
                    },
                },
            ];

            App.Utils.Message.show(lang('delete_service_category'), lang('delete_record_prompt'), buttons);
        });

        /**
         * Event: Categories Save Button "Click"
         */
        $servicesCategoriesToolbar.on('click', '#save-service-category', () => {
            if (!validate()) {
                return;
            }

            const serviceCategory = {
                name: $name.val(),
                description: $description.val(),
            };

            if ($id.val() !== '') {
                serviceCategory.id = $id.val();
            }

            App.Pages.ServiceCategories.save(serviceCategory);
        });

        /**
         * Event: Cancel Service-Category Button "Click"
         */
        $servicesCategoriesToolbar.on('click', '#cancel-service-category', () => {
            const id = $id.val();

            App.Pages.ServiceCategories.resetForm();

            if (id !== '') {
                select(id, true);
            }
        });

        /**
         * Event: Clear Services Button "Click"
         */
        $servicesCategoriesToolbar.on('click', '#clear-service-categories', () => {
            $filterServiceCategories.find('.key').val('');
            App.Pages.ServiceCategories.resetForm();
            App.Pages.ServiceCategories.filter('');
        });
    }

    /**
     * Filter service categories records.
     *
     * @param {String} keyword This key string is used to filter the service-category records.
     * @param {Number} selectId Optional, if set then after the filter operation the record with the given
     * ID will be selected (but not displayed).
     * @param {Boolean} show Optional (false), if true then the selected record will be displayed on the form.
     */
    function filter(keyword, selectId = null, show = false) {
        App.Http.ServiceCategories.search(keyword, filterLimit).then((response) => {
            filterResults = response;

            $('#service-categories-list').empty();

            response.forEach((serviceCategory) => {
                $('#service-categories-list')
                    .append(App.Pages.ServiceCategories.getFilterHtml(serviceCategory))
                    .append($('<hr/>'));
            });

            if (response.length === 0) {
                $('#service-categories-list').append(
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
                        App.Pages.ServiceCategories.filter(keyword, selectId, show);
                    },
                }).appendTo('#service-categories-list');
            }

            if (selectId) {
                select(selectId, show);
            }
        });
    }

    /**
     * Save a service-category record to the database (via AJAX post).
     *
     * @param {Object} serviceCategory Contains the service-category data.
     */
    function save(serviceCategory) {
        App.Http.ServiceCategories.save(serviceCategory).then((response) => {
            App.Layouts.Backend.displayNotification(lang('service_category_saved'));
            App.Pages.ServiceCategories.resetForm();
            $filterServiceCategories.find('.key').val('');
            App.Pages.ServiceCategories.filter('', response.id, true);
        });
    }

    /**
     * Delete service-category record.
     *
     * @param {Number} id Record ID to be deleted.
     */
    function remove(id) {
        App.Http.ServiceCategories.destroy(id).then(() => {
            App.Layouts.Backend.displayNotification(lang('service_category_deleted'));
            App.Pages.ServiceCategories.resetForm();
            App.Pages.ServiceCategories.filter($('#filter-service-categories-form .key').val());
        });
    }

    /**
     * Display a service-category record on the form.
     *
     * @param {Object} serviceCategory Contains the service-category data.
     */
    function display(serviceCategory) {
        $id.val(serviceCategory.id);
        $name.val(serviceCategory.name);
        $description.val(serviceCategory.description);
    }

    /**
     * Validate service-category data before save (insert or update).
     *
     * @return {Boolean} Returns the validation result.
     */
    function validate() {
        $serviceCategories.find('.is-invalid').removeClass('is-invalid').addClass('border-primary');

        try {
            let missingRequired = false;

            $serviceCategories.find('.required').each((index, fieldEl) => {
                if (!$(fieldEl).val()) {
                    $(fieldEl).removeClass('border border-primary');
                    $(fieldEl).addClass('is-invalid');
                    missingRequired = true;
                }
            });

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
     * Bring the service-category form back to its initial state.
     */
    function resetForm() {
        $serviceCategories.find('.selected').removeClass('selected');
        $filterServiceCategories.find('button').prop('disabled', false);
        $serviceCategories.find('#service-categories-list').css('color', '');

        $serviceCategories.find('.record-details').find('input, select, textarea').val('').prop('disabled', true).addClass('disabled');
        $serviceCategories.find('.record-details .form-label span').prop('hidden', true);

        $servicesCategoriesToolbar.find('#add-edit-delete-group').show();
        $servicesCategoriesToolbar.find('#save-cancel-group').hide();
        $('#edit-service-category, #delete-service-category').prop('disabled', true);

        $serviceCategories.find('.record-details .is-invalid').removeClass('is-invalid').addClass('border border-primary');
    }

    /**
     * Get the filter results row HTML code.
     *
     * @param {Object} serviceCategory Contains the service-category data.
     *
     * @return {String} Returns the record HTML code.
     */
    function getFilterHtml(serviceCategory) {
        return $('<div/>', {
            'class': 'service-category-row entry',
            'data-id': serviceCategory.id,
            'html': [
                $('<strong/>', {
                    'text': serviceCategory.name,
                }),
                $('<br/>'),
            ],
        });
    }

    /**
     * Select a specific record from the current filter results.
     *
     * If the service-category ID does not exist in the list then no record will be selected.
     *
     * @param {Number} id The record ID to be selected from the filter results.
     * @param {Boolean} show Optional (false), if true then the method will display the record on the form.
     */
    function select(id, show = false) {
        $serviceCategories.find('.selected').removeClass('selected');

        $serviceCategories.find('.service-category-row[data-id="' + id + '"]').addClass('selected');

        if (show) {
            const serviceCategory = filterResults.find((serviceCategory) => Number(serviceCategory.id) === Number(id));

            App.Pages.ServiceCategories.display(serviceCategory);

            $('#edit-service-category, #delete-service-category').prop('disabled', false);
        }
    }

    /**
     * Initialize the module.
     */
    function initialize() {
        App.Pages.ServiceCategories.resetForm();
        App.Pages.ServiceCategories.filter('');
        App.Pages.ServiceCategories.addEventListeners();
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
