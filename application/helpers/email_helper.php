<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('shouldHighlight')) {
    // Helper function to check if field should be highlighted
    function shouldHighlight($fieldName, $fieldNames_changed)
    {
        return in_array($fieldName, $fieldNames_changed);
    }
}


if (!function_exists('getHighlightStyle')) {
    // Helper function to get highlight style
    function getHighlightStyle($fieldName, $fieldNames_changed)
    {
        return shouldHighlight($fieldName, $fieldNames_changed)
            ? 'color: #dc3545; font-weight: bold;'
            : '';
    }
}
