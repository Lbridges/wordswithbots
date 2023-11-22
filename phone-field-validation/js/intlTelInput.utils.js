jQuery(document).ready(function($) {
    // Initialize International Telephone Input
    var iti = utils.getITIPhoneInput($('#phone'));
    var phoneError = $('#phoneError');
    var input = $('#phone');

    // Validate phone number on form submission
    $('#phone-validation-form').submit(function(e) {
        e.preventDefault();

        if (!iti.isValidNumber()) {
            phoneError.textContent = 'Invalid phone number';
            input.classList.add('error');
            input.focus();
            return false;
        }

        phoneError.textContent = '';
        input.classList.remove('error');

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
    });
});
