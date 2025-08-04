<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.4.0
 * ---------------------------------------------------------------------------- */

/**
 * Notifications library.
 *
 * Handles the notifications related functionality.
 *
 * @package Libraries
 */
class Notifications
{
    /**
     * @var EA_Controller|CI_Controller
     */
    protected EA_Controller|CI_Controller $CI;

    /**
     * Notifications constructor.
     */
    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model('admins_model');
        $this->CI->load->model('appointments_model');
        $this->CI->load->model('providers_model');
        $this->CI->load->model('secretaries_model');
        $this->CI->load->model('settings_model');

        $this->CI->load->library('email_messages');
        $this->CI->load->library('ics_file');
        $this->CI->load->library('timezones');
    }

    /**
     * Send the required notifications, related to an appointment creation/modification.
     *
     * @param array $appointment Appointment data.
     * @param array $service Service data.
     * @param array $provider Provider data.
     * @param array $customer Customer data.
     * @param array $settings Required settings.
     * @param bool|false $manage_mode Manage mode.
     */
    public function notify_appointment_saved(
        array $appointment,
        array $service,
        array $provider,
        array $customer,
        array $settings,
        bool $manage_mode = false,
        array $fields_changed = []
    ): void {
        try {
            $current_language = config('language');

            $customer_link = site_url('booking/reschedule/' . $appointment['hash']);

            $provider_link = site_url('calendar/reschedule/' . $appointment['hash']);

            $ics_stream = $this->CI->ics_file->get_stream($appointment, $service, $provider, $customer);

            // Flatten $fields_changed to ensure it's an array of strings
            // $fields_changed_flat = array_map(function($item) {
            //     return is_array($item) ? json_encode($item) : $item;
            // }, $fields_changed);
            // $fields_changed = implode(', ', $fields_changed_flat);

            $fieldNames_changed = array();

            if ($manage_mode) {
                    $tableBuilder = '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">';
                    $tableBuilder .= '<thead><tr><th>Field</th><th>Current Value</th><th>Original Value</th></tr></thead>';
                    $tableBuilder .= '<tbody>';
                foreach ($fields_changed as $field_changed) {
                    if (is_array($field_changed)) {
                        $fieldNames_changed[] = $field_changed['field'];
                        $tableBuilder .= '<tr>';
                        $tableBuilder .= '<td>' . htmlspecialchars((preg_match('/^CustomField[1-5]$/', $field_changed['field'])) ? setting('label_custom_field_' . substr($field_changed['field'], -1)) : $field_changed['field']) . '</td>';
                        $tableBuilder .= '<td>' . htmlspecialchars($field_changed['current']) . '</td>';
                        $tableBuilder .= '<td>' . htmlspecialchars($field_changed['original']) . '</td>';
                        $tableBuilder .= '</tr>';
                    }
                }
                $tableBuilder .= '</tbody>';
                $tableBuilder .= '</table>';
            }

            // Notify customer.
            $send_customer = !empty($customer['email']) && filter_var(setting('customer_notifications'), FILTER_VALIDATE_BOOLEAN);

            if ($send_customer === true) {
                sleep(2); // Delay before sending customer notification
                config(['language' => $customer['language']]);
                $this->CI->lang->load('translations');
                $subject = $manage_mode ? lang('customer_appointment_details_changed') : lang('appointment_booked');
                $message = $manage_mode ? lang('customer_fields_changed') : lang('thank_you_for_appointment');

                $this->CI->email_messages->send_appointment_saved(
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $subject,
                    $message,
                    $customer_link,
                    $customer['email'],
                    $ics_stream,
                    $customer['timezone'],
                    $fieldNames_changed
                );
            }


            // Notify provider.
            $send_provider = filter_var(
                $this->CI->providers_model->get_setting($provider['id'], 'notifications'),
                FILTER_VALIDATE_BOOLEAN,
            );

            if ($send_provider === true) {
                sleep(2); // Delay before sending provider notification
                config(['language' => $provider['language']]);
                $this->CI->lang->load('translations');
                $subject = $manage_mode ? lang('provider_appointment_details_changed') : lang('appointment_added_to_your_plan');
                $message = $manage_mode ? lang('fields_changed') .  ' ' . $tableBuilder : lang('appointment_link_description');

                $this->CI->email_messages->send_appointment_saved(
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $subject,
                    $message,
                    $provider_link,
                    $provider['email'],
                    $ics_stream,
                    $provider['timezone'],
                    $fieldNames_changed
                );
            }

            // Notify admins.
            $admins = $this->CI->admins_model->get();

            foreach ($admins as $admin) {
                if ($admin['settings']['notifications'] === '0') {
                    continue;
                }

                sleep(2); // Delay before sending admin notification
                config(['language' => $admin['language']]);
                $this->CI->lang->load('translations');
                $subject = $manage_mode ? lang('admins_appointment_details_changed') : lang('appointment_added_to_system');
                $message = $manage_mode ? lang('fields_changed') .  ' ' . $tableBuilder : lang('appointment_link_description');

                $this->CI->email_messages->send_appointment_saved(
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $subject,
                    $message,
                    $provider_link,
                    $admin['email'],
                    $ics_stream,
                    $admin['timezone'],
                    $fieldNames_changed
                );
            }

            // Notify secretaries.
            $secretaries = $this->CI->secretaries_model->get();

            foreach ($secretaries as $secretary) {
                if ($secretary['settings']['notifications'] === '0') {
                    continue;
                }

                if (!in_array($provider['id'], $secretary['providers'])) {
                    continue;
                }

                sleep(2); // Delay before sending secretary notification
                config(['language' => $secretary['language']]);
                $this->CI->lang->load('translations');
                $subject = $manage_mode ? lang('admins_appointment_details_changed') : lang('appointment_added_to_system');
                $message = $manage_mode ? lang('fields_changed') . ' ' . $tableBuilder : lang('appointment_link_description');

                $this->CI->email_messages->send_appointment_saved(
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $subject,
                    $message,
                    $provider_link,
                    $secretary['email'],
                    $ics_stream,
                    $secretary['timezone'],
                    $fieldNames_changed
                );
            }
        } catch (Throwable $e) {
            log_message(
                'error',
                'Notifications - Could not email confirmation details of appointment (' .
                    ($appointment['id'] ?? '-') .
                    ') : ' .
                    $e->getMessage(),
            );
            log_message('error', $e->getTraceAsString());
        } finally {
            config(['language' => $current_language ?? 'english']);
            $this->CI->lang->load('translations');
        }
    }

    /**
     * Send the required notifications, related to an appointment removal.
     *
     * @param array $appointment Appointment data.
     * @param array $service Service data.
     * @param array $provider Provider data.
     * @param array $customer Customer data.
     * @param array $settings Required settings.
     */
    public function notify_appointment_deleted(
        array $appointment,
        array $service,
        array $provider,
        array $customer,
        array $settings,
        string $cancellation_reason = '',
    ): void {
        try {
            $current_language = config('language');

            // Notify provider.
            $send_provider = filter_var(
                $this->CI->providers_model->get_setting($provider['id'], 'notifications'),
                FILTER_VALIDATE_BOOLEAN,
            );

            if ($send_provider === true) {
                sleep(2); // Delay before sending provider notification
                config(['language' => $provider['language']]);
                $this->CI->lang->load('translations');

                $subject = lang('provider_appointment_cancelled_title');

                $this->CI->email_messages->send_appointment_deleted(
                    $subject,
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $provider['email'],
                    $cancellation_reason,
                    $provider['timezone'],
                );
            }

            // Notify customer.
            $send_customer =
                !empty($customer['email']) && filter_var(setting('customer_notifications'), FILTER_VALIDATE_BOOLEAN);

            if ($send_customer === true) {
                sleep(2); // Delay before sending customer notification
                config(['language' => $customer['language']]);
                $this->CI->lang->load('translations');

                $subject = lang('customer_appointment_cancelled_title');

                $this->CI->email_messages->send_appointment_deleted(
                    $subject,
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $customer['email'],
                    $cancellation_reason,
                    $customer['timezone'],
                );
            }

            // Notify admins.
            $admins = $this->CI->admins_model->get();

            foreach ($admins as $admin) {
                if ($admin['settings']['notifications'] === '0') {
                    continue;
                }

                sleep(2); // Delay before sending admin notification
                config(['language' => $admin['language']]);
                $this->CI->lang->load('translations');

                $subject = lang('admins_appointment_cancelled_title');

                $this->CI->email_messages->send_appointment_deleted(
                    $subject,
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $admin['email'],
                    $cancellation_reason,
                    $admin['timezone'],
                );
            }

            // Notify secretaries.
            $secretaries = $this->CI->secretaries_model->get();

            foreach ($secretaries as $secretary) {
                if ($secretary['settings']['notifications'] === '0') {
                    continue;
                }

                if (!in_array($provider['id'], $secretary['providers'])) {
                    continue;
                }

                sleep(2); // Delay before sending secretary notification
                config(['language' => $secretary['language']]);
                $this->CI->lang->load('translations');

                $subject = lang('admins_appointment_cancelled_title');

                $this->CI->email_messages->send_appointment_deleted(
                    $subject,
                    $appointment,
                    $provider,
                    $service,
                    $customer,
                    $settings,
                    $secretary['email'],
                    $cancellation_reason,
                    $secretary['timezone'],
                );
            }
        } catch (Throwable $e) {
            log_message(
                'error',
                'Notifications - Could not email cancellation details of appointment (' .
                    ($appointment['id'] ?? '-') .
                    ') : ' .
                    $e->getMessage()
            );
            log_message('error', $e->getTraceAsString());
        } finally {
            config(['language' => $current_language ?? 'english']);
            $this->CI->lang->load('translations');
        }
    }
}
