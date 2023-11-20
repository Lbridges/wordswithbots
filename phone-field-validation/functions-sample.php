<?php
// functions.php in your theme

function theme_enqueue_scripts() {
    // Enqueue scripts from the phone-validator plugin
    wp_enqueue_script('util');
    wp_enqueue_script('intlTelInput');
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
