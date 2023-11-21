<?php
/*
Plugin Name: Phone Validation Plugin
Description: Validates phone numbers using the intlTelInput library.
Version: 1.0
Author: Your Name
*/

function enqueue_phone_validation_scripts() {
    wp_enqueue_script( 'intl-tel-input', plugin_dir_url( __FILE__ ) . 'js/intlTelInput.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'phone-validation', plugin_dir_url( __FILE__ ) . 'js/phone-validation.js', array( 'jquery', 'intl-tel-input' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_phone_validation_scripts' );

function add_phone_input_field() {
    echo '<div class="form-group">';
    echo '<label for="daytimeTelephoneNumber">Phone</label>';
    echo '<input type="tel" class="form-control" name="daytimeTelephoneNumber" id="daytimeTelephoneNumber" aria-describedby="phone-error" required>';
    echo '<div id="phone-error" style="color: red;"></div>';
    echo '</div>';
}
add_action( 'wp_footer', 'add_phone_input_field' );

/*

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
