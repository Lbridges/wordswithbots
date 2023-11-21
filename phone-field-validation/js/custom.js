document.addEventListener('DOMContentLoaded', function () {
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
});
