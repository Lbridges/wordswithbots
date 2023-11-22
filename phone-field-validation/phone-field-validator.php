<?php

/*
Plugin Name: Phone Validation Plugin
Plugin URI: https://example.com/phone-validation-plugin
Description: A simple plugin to validate phone numbers using International Telephone Input.
Version: 1.0.0
Author: Bard
Author URI: https://example.com
License: GPLv2 or later
*/

// Enqueue necessary scripts
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('intl-tel-input', plugins_url('/js/intlTelInput.min.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_enqueue_script('utils', plugins_url('/js/utils.js', __FILE__), array('jquery'), '1.0.0', true);
});

// Initialize International Telephone Input on existing form
add_action('wp_footer', function() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            // Select the existing form element
            var formElement = $('#your-form-id');

            // Initialize International Telephone Input for the phone input field
            var phoneInput = formElement.find('input[type="tel"]');
            var iti = utils.getITIPhoneInput(phoneInput);

            // Validate phone number on form submission
            formElement.submit(function(e) {
                e.preventDefault();

                if (!iti.isValidNumber()) {
                    alert('Please enter a valid phone number.');
                    return false;
                }

                // Submit the form here
                console.log('Phone number:', iti.getNumber());
            });
        });
    </script>
    <?php
});
----------------------------------------------------------------
//MAIN SCRIPT 
jQuery(document).ready(function($) {
    // Initialize International Telephone Input
    var iti = utils.getITIPhoneInput($('#phone'));
    var phoneError = $('#phoneError');
    var input = $('#phone');

    // Enable submit button only when all required fields are valid
    function updateSubmitButtonState() {
        var nameIsValid = $('#name').val() !== '';
        var emailIsValid = $('#email').val() !== '';
        var phoneIsValid = iti.isValidNumber();

        if (nameIsValid && emailIsValid && phoneIsValid) {
            $('#phone-validation-form button').prop('disabled', false);
        } else {
            $('#phone-validation-form button').prop('disabled', true);
        }
    }

    // Validate phone number on form submission
    $('#phone-validation-form').submit(function(e) {
        e.preventDefault();

        if (!iti.isValidNumber()) {
            phoneError.textContent = 'Invalid phone number';
            input.classList.add('error');
            input.focus();
            return false;
        }

        // Submit the form here
        console.log('Phone number:', iti.getNumber());
    });

    // Validate phone number on blur
    input.addEventListener('blur', function() {
        if (!iti.isPossibleNumber()) {
            phoneError.textContent = 'Invalid phone number';
            input.classList.add('error');
        } else {
            phoneError.textContent = '';
            input.classList.remove('error');
        }

        updateSubmitButtonState();
    });

    // Validate other required fields on blur
    $('#name').on('blur', updateSubmitButtonState);
    $('#email').on('blur', updateSubmitButtonState);

    // Initial validation to set submit button state
    updateSubmitButtonState();
});

/*
----------------------------------------------------------------------

This updated code incorporates the following best practices:

Client-side validation: The validation logic is performed on the client-side, providing immediate feedback to the user without the need for page reloads.

Incremental validation: The validation is performed incrementally as the user fills out the form, ensuring that fields are validated before the submit button is enabled.

Submit button control: The submit button is disabled initially and only enabled when all required fields are valid, preventing form submission with incomplete or invalid data.

User-friendly experience: The plugin provides clear error messages and updates the submit button state dynamically, guiding the user through the form completion process.

Modular design: The plugin is designed as a separate module, allowing it to be easily integrated into existing forms without affecting other functionalities.



Given the requirement of sharing the phone field validation method across multiple sites with different themes, using a plugin becomes a sensible approach. A plugin allows for a modular and portable solution that can be easily implemented on various WordPress installations.

By creating a plugin to handle the phone field validation scripts, you provide a self-contained and consistent solution that can be activated on different sites without needing to modify individual theme files. This approach offers the following benefits:

Portability: The plugin, with its validation scripts, can be installed and activated on any WordPress site independently of the theme. This makes it easy to replicate the phone field validation across various projects.

Centralized Updates: If there are updates or improvements to the validation scripts, you can manage them in one central location within the plugin. This ensures consistency across all sites using the plugin.

Modularity: The validation logic is encapsulated within the plugin, promoting a modular design. This can be especially helpful if you plan to extend or modify the validation logic in the future.

Ease of Maintenance: If there are changes or enhancements to the validation process, you only need to update the plugin once, and the changes will propagate to all sites using the plugin.

To summarize, creating a WordPress plugin for the phone field validation scripts is a practical and scalable solution, especially when the functionality needs to be shared across multiple sites with different themes.
   
    
    */
