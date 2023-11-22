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


/*
----------------------------------------------------------------------
// Modified JavaScript
const inputField = document.querySelector(`.${intlTelInputConfig.inputClass}`);
const iti = window.intlTelInput(inputField, {
    utilsScript: intlTelInputConfig.utilsScript,
    preferredCountries: intlTelInputConfig.preferredCountries
});

const phoneError = document.getElementById('phone-error');

function validatePhone() {
    if (!iti.isPossibleNumber()) {
        phoneError.textContent = 'Invalid phone number';
        inputField.classList.add('error');
    }
}

inputField.addEventListener('blur', validatePhone);


Given the requirement of sharing the phone field validation method across multiple sites with different themes, using a plugin becomes a sensible approach. A plugin allows for a modular and portable solution that can be easily implemented on various WordPress installations.

By creating a plugin to handle the phone field validation scripts, you provide a self-contained and consistent solution that can be activated on different sites without needing to modify individual theme files. This approach offers the following benefits:

Portability: The plugin, with its validation scripts, can be installed and activated on any WordPress site independently of the theme. This makes it easy to replicate the phone field validation across various projects.

Centralized Updates: If there are updates or improvements to the validation scripts, you can manage them in one central location within the plugin. This ensures consistency across all sites using the plugin.

Modularity: The validation logic is encapsulated within the plugin, promoting a modular design. This can be especially helpful if you plan to extend or modify the validation logic in the future.

Ease of Maintenance: If there are changes or enhancements to the validation process, you only need to update the plugin once, and the changes will propagate to all sites using the plugin.

To summarize, creating a WordPress plugin for the phone field validation scripts is a practical and scalable solution, especially when the functionality needs to be shared across multiple sites with different themes.
   
    
    */
