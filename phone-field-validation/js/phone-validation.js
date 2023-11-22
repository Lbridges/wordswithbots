jQuery(document).ready(function($) {
    // Load International Telephone Input CSS from CDN
    $('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/css/intlTelInput.css">').appendTo('head');

    // Load International Telephone Input JavaScript from CDN
    $.getScript('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/intlTelInput.min.js', function() {
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
});
