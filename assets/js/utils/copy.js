// JavaScript Document

"use strict";

window.App.Utils.Copy = (function () {
    /**
    * Copy text to clipboard with user feedback
    *
    * @param {string} text - Text to copy
    * @param {jQuery} $button - Button element for feedback
    */
    function copyToClipboard(text, $button) {
        // Clipboard API is only available in secure contexts (HTTPS, localhost)
        if (navigator.clipboard && window.isSecureContext) {
            // Modern approach
            navigator.clipboard.writeText(text).then(() => {
                showCopyFeedback($button, true);
            }).catch(() => {
                // Fallback if clipboard API fails
                fallbackCopyToClipboard(text, $button);
            });
        } else {
            // Fallback for older browsers or non-secure contexts
            fallbackCopyToClipboard(text, $button);
        }
    }

    /**
     * Enhanced fallback method that works on HTTP
     *
     * @param {string} text - Text to copy
     * @param {jQuery} $button - Button element for feedback
     */
    function fallbackCopyToClipboard(text, $button) {
        // Create a temporary textarea element
        const $textarea = $('<textarea/>', {
            'value': text,
            'style': 'position: absolute; left: -9999px; top: -9999px; width: 1px; height: 1px; z-index: -1000;'
        });

        // Add to DOM
        $('body').append($textarea);

        // Store current focus
        const activeElement = document.activeElement;

        try {
            // Focus and select the textarea content
            $textarea[0].focus();
            $textarea[0].select();

            // Ensure the text is selected (important for some browsers)
            $textarea[0].setSelectionRange(0, text.length);

            // Special handling for mobile browsers
            if (/ipad|iphone|ipod/.test(navigator.userAgent.toLowerCase())) {
                const range = document.createRange();
                range.selectNodeContents($textarea[0]);
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
                $textarea[0].setSelectionRange(0, 999999);
            }

            // Execute the copy command
            const successful = document.execCommand('copy');

            if (successful) {
                console.log('Text copied using execCommand');
                showCopyFeedback($button, true);
            } else {
                console.error('execCommand copy failed');
                showCopyFeedback($button, false);
            }

        } catch (err) {
            console.error('Copy operation failed:', err);
            showCopyFeedback($button, false);
        } finally {
            // Restore focus to previously active element
            if (activeElement && activeElement.focus) {
                activeElement.focus();
            }

            // Remove the temporary textarea
            $textarea.remove();
        }
    }

    /**
     * Show visual feedback when copying
     *
     * @param {jQuery} $button - Button element
     * @param {boolean} success - Whether copy was successful
     */
    function showCopyFeedback($button, success) {
        const originalHtml = $button.html();
        const originalTitle = $button.attr('title');

        if (success) {
            $button.html('<i class="fas fa-check text-success"></i>');
            $button.attr('title', lang('copied'));

            // Show success notification
            if (App.Layouts && App.Layouts.Backend && App.Layouts.Backend.displayNotification) {
                App.Layouts.Backend.displayNotification(lang('link_copied_to_clipboard'));
            } else {
                console.log('✅ Link copied to clipboard');
            }
        } else {
            $button.html('<i class="fas fa-times text-danger"></i>');
            $button.attr('title', lang('copy_failed'));

            // Show error notification
            if (App.Layouts && App.Layouts.Backend && App.Layouts.Backend.displayNotification) {
                App.Layouts.Backend.displayNotification(lang('copy_failed'), 'error');
            } else {
                console.error('❌ Failed to copy link');
            }
        }

        // Reset button after 2 seconds
        setTimeout(() => {
            $button.html(originalHtml);
            $button.attr('title', originalTitle);
        }, 2000);
    }

    return {
        copyToClipboard
    }
})();