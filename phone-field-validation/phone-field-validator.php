<?php
/**
 * Plugin Name: Phone Validator
 * Description: A simple phone input validator.
 * Version: 1.0
 * Author: MVW Development
 */

// Enqueue JavaScript files
function phone_validator_enqueue_scripts() {
    wp_enqueue_script('phone-validator', plugins_url('js/validator.js', __FILE__), array('jquery'), '1.0', true);
}

// Hook the function into WordPress
add_action('wp_enqueue_scripts', 'phone_validator_enqueue_scripts');
