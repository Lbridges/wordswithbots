// utils.js
jQuery(document).ready(function($) {
    // Define preferred countries
    var preferredCountries = ["US", "CA", "GB"];

    function getITIPhoneInput(inputElement) {
        return window.intlTelInput(inputElement, {
            utilsScript: plugins_url('/js/intlTelInput.utils.js', __FILE__),
            nationalDropDown: true,
            preferredCountries: preferredCountries
        });
    }
});

