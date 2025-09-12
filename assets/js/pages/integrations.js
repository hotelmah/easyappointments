/**
 * Integrations page.
 *
 * This module implements the functionality of the integrations page.
 */
App.Pages.Integrations = (function () {
        /**
     * Initialize the module.
     */
    function initialize() {
        const urlSegments = document.URL.split('/');
        const lastSegment = urlSegments[urlSegments.length - 1];

        $('#settings-nav a').removeClass('active');
        $('#settings-nav a#' + lastSegment).addClass('active');
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {};
})();
