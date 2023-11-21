<?php
/**
*Plugin Name: Phone Validator
*Description: A simple phone input validator
*Version: 1.0
*Author: MVW Development
*/

function phone_validator_enqueue_scripts() {
    // Check if jQuery is loaded
    if (!wp_script_is('jquery', 'enqueued')) {
        // If not, enqueue jQuery first
        wp_enqueue_script('jquery');
    }

    // Enqueue intlTelInput.min.js with jQuery as a dependency
    wp_enqueue_script('intlTelInput', plugins_url('js/intlTelInput.min.js', __FILE__), array('jquery'), '1.0', true);

    // Enqueue util.js with intlTelInput as a dependency
    wp_enqueue_script('util', plugins_url('js/utils.js', __FILE__), array('intlTelInput'), '1.0', true);

    // Localize the script to pass parameters to JavaScript
    wp_localize_script('intlTelInput', 'intlTelInputConfig', array(
        'inputField' => '#kb_field__dd1339-e6_4', // Adjust to match the actual ID of your input field
        'preferredCountries' => array("gb", "fr", "de", "it", "es")
    ));
}

// Hook the function into WordPress
add_action('wp_enqueue_scripts', 'phone_validator_enqueue_scripts');


/*

// Modified JavaScript
const inputField = document.querySelector(intlTelInputConfig.inputField);
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
