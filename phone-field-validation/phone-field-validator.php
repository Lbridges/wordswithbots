<?php
/**
 * Plugin Name: Phone Validator
 * Description: A simple phone input validator.
 * Version: 1.0
 * Author: Your Name
 */

// Enqueue JavaScript files
function phone_validator_enqueue_scripts() {
    // Enqueue intlTelInput.min.js in the footer
    wp_enqueue_script('intlTelInput', plugins_url('js/intlTelInput.min.js', __FILE__), array(), '1.0', true);

    // Enqueue util.js in the footer with 'intlTelInput' as a dependency
    wp_enqueue_script('util', plugins_url('js/util.js', __FILE__), array('intlTelInput'), '1.0', true);
}

// Hook the function into WordPress
add_action('wp_enqueue_scripts', 'phone_validator_enqueue_scripts');

/*
Given the requirement of sharing the phone field validation method across multiple sites with different themes, using a plugin becomes a sensible approach. A plugin allows for a modular and portable solution that can be easily implemented on various WordPress installations.

By creating a plugin to handle the phone field validation scripts, you provide a self-contained and consistent solution that can be activated on different sites without needing to modify individual theme files. This approach offers the following benefits:

Portability: The plugin, with its validation scripts, can be installed and activated on any WordPress site independently of the theme. This makes it easy to replicate the phone field validation across various projects.

Centralized Updates: If there are updates or improvements to the validation scripts, you can manage them in one central location within the plugin. This ensures consistency across all sites using the plugin.

Modularity: The validation logic is encapsulated within the plugin, promoting a modular design. This can be especially helpful if you plan to extend or modify the validation logic in the future.

Ease of Maintenance: If there are changes or enhancements to the validation process, you only need to update the plugin once, and the changes will propagate to all sites using the plugin.

To summarize, creating a WordPress plugin for the phone field validation scripts is a practical and scalable solution, especially when the functionality needs to be shared across multiple sites with different themes.
    
 call file:  
 <script src="<?php echo plugins_url('js/intlTelInput.min.js', __FILE__); ?>"></script>

 const input = document.querySelector("#phone");
const iti = window.intlTelInput(input, {
    utilsScript: "<?php echo plugins_url('js/util.js', __FILE__); ?>",
    // Other configuration options...
});   
    
    
    */
