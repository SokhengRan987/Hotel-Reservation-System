/**
 * Payment Form Handler
 * Handles form validation, payment method switching, and submission
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    if (!form) return;

    const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
    const paymentDetailsSection = document.getElementById('payment-details-section');
    const submitBtn = document.getElementById('submitBtn');

    // Initialize payment method listeners
    paymentMethodInputs.forEach(input => {
        input.addEventListener('change', handlePaymentMethodChange);
    });

    /**
     * Handle payment method change
     * Shows/hides relevant payment fields and updates button state
     */
    function handlePaymentMethodChange() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const creditCardFields = document.getElementById('credit-card-fields');
        const paypalFields = document.getElementById('paypal-fields');
        const abaQrFields = document.getElementById('aba-qr-fields');

        // Hide all sections
        creditCardFields?.classList.add('hidden');
        paypalFields?.classList.add('hidden');
        abaQrFields?.classList.add('hidden');

        // Show selected section
        switch(selectedMethod) {
            case 'credit_card':
                creditCardFields?.classList.remove('hidden');
                updateSubmitButton('Pay via Card');
                break;
            case 'paypal':
                paypalFields?.classList.remove('hidden');
                updateSubmitButton('Continue to PayPal');
                break;
            case 'aba_qr':
                abaQrFields?.classList.remove('hidden');
                updateSubmitButton('Confirm ABA Payment');
                break;
        }

        // Show details section and enable button
        paymentDetailsSection.classList.remove('hidden');
        enableSubmitButton();
    }

    /**
     * Handle form submission
     */
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Clear previous errors
        clearAllErrors();

        // Validate payment method
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedMethod) {
            showError('payment-method-error', 'Please select a payment method');
            return;
        }

        // Validate based on payment method
        if (selectedMethod.value === 'credit_card') {
            if (!validateCreditCard()) return;
        }

        // Disable button and show loading state
        disableSubmitButton();

        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || result.message || 'Payment failed');
            }

            if (result.redirect) {
                window.location.href = result.redirect;
            } else if (result.success) {
                window.location.href = result.redirect || '/customer/bookings';
            }
        } catch (error) {
            showError('form-error', error.message);
            enableSubmitButton();
        }
    });

    /**
     * Validate credit card details
     */
    function validateCreditCard() {
        let isValid = true;
        const cardName = form.querySelector('input[name="card_name"]');
        const cardNumber = form.querySelector('input[name="card_number"]');
        const cardExpiry = form.querySelector('input[name="card_expiry"]');
        const cardCvv = form.querySelector('input[name="card_cvv"]');

        clearFieldErrors();

        // Validate cardholder name
        if (!cardName.value.trim()) {
            addFieldError(cardName, 'Cardholder name is required');
            isValid = false;
        } else if (cardName.value.trim().length < 3) {
            addFieldError(cardName, 'Name must be at least 3 characters');
            isValid = false;
        }

        // Validate card number
        const cardNum = cardNumber.value.replace(/\s/g, '');
        if (!cardNum || cardNum.length < 13 || cardNum.length > 19 || !/^\d+$/.test(cardNum)) {
            addFieldError(cardNumber, 'Please enter a valid card number');
            isValid = false;
        } else if (!luhnCheck(cardNum)) {
            addFieldError(cardNumber, 'Invalid card number');
            isValid = false;
        }

        // Validate expiry
        const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
        if (!cardExpiry.value.match(expiryRegex)) {
            addFieldError(cardExpiry, 'Use MM/YY format');
            isValid = false;
        } else if (isExpired(cardExpiry.value)) {
            addFieldError(cardExpiry, 'Card is expired');
            isValid = false;
        }

        // Validate CVV
        if (!cardCvv.value.match(/^\d{3,4}$/)) {
            addFieldError(cardCvv, 'Enter a valid CVV (3-4 digits)');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Luhn algorithm for card number validation
     */
    function luhnCheck(cardNum) {
        let sum = 0;
        let isEven = false;

        for (let i = cardNum.length - 1; i >= 0; i--) {
            let digit = parseInt(cardNum[i], 10);

            if (isEven) {
                digit *= 2;
                if (digit > 9) {
                    digit -= 9;
                }
            }

            sum += digit;
            isEven = !isEven;
        }

        return sum % 10 === 0;
    }

    /**
     * Check if card expiry is in the past
     */
    function isExpired(expiryStr) {
        const [month, year] = expiryStr.split('/');
        const expiry = new Date(2000 + parseInt(year), parseInt(month) - 1);
        const today = new Date();
        return expiry < today;
    }

    /**
     * Add error to field
     */
    function addFieldError(field, message) {
        field.classList.add('error');
        const errorMsg = field.nextElementSibling;
        if (errorMsg?.classList.contains('error-message')) {
            errorMsg.textContent = message;
            errorMsg.classList.remove('hidden');
        }
    }

    /**
     * Clear all field errors
     */
    function clearFieldErrors() {
        document.querySelectorAll('input[data-validate]').forEach(input => {
            input.classList.remove('error');
            const errorMsg = input.nextElementSibling;
            if (errorMsg?.classList.contains('error-message')) {
                errorMsg.classList.add('hidden');
            }
        });
    }

    /**
     * Show form error
     */
    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    /**
     * Clear all errors
     */
    function clearAllErrors() {
        document.getElementById('form-error')?.classList.add('hidden');
        document.getElementById('payment-method-error')?.classList.add('hidden');
        clearFieldErrors();
    }

    /**
     * Enable submit button
     */
    function enableSubmitButton() {
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
    }

    /**
     * Disable submit button with loading state
     */
    function disableSubmitButton() {
        submitBtn.disabled = true;
        const loadingSpan = document.getElementById('submitBtnLoading');
        const textSpan = document.getElementById('submitBtnText');
        if (loadingSpan && textSpan) {
            loadingSpan.classList.remove('hidden');
            textSpan.classList.add('hidden');
        }
    }

    /**
     * Update submit button text
     */
    function updateSubmitButton(text) {
        const submitBtnText = document.getElementById('submitBtnText');
        if (submitBtnText) {
            submitBtnText.textContent = text;
        }
    }

    // Format card number input with spaces
    const cardNumberInput = form.querySelector('input[name="card_number"]');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            this.value = this.value
                .replace(/\s/g, '')
                .replace(/[^\d]/g, '')
                .match(/.{1,4}/g)
                ?.join(' ') || this.value;
        });
    }

    // Format expiry input
    const expiryInput = form.querySelector('input[name="card_expiry"]');
    if (expiryInput) {
        expiryInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^\d/]/g, '');
            if (this.value.length === 2 && !this.value.includes('/')) {
                this.value += '/';
            }
        });
    }

    // Allow only numbers for CVV
    const cvvInput = form.querySelector('input[name="card_cvv"]');
    if (cvvInput) {
        cvvInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^\d]/g, '');
        });
    }
});
