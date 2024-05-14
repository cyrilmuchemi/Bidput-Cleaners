document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('signupForm');

    form.addEventListener('submit', function(event){
        event.preventDefault();
        // Reset error messages
        clearErrors();
        // Validate form fields
        if (!validateForm(this)) {
            return;
        }
        // If all the validation has passed
        const formData = new FormData(this);
        formData.append('data_type', 'signup');
        sendData(formData);
    });
});

function clearErrors() {
    const errorFields = document.querySelectorAll('.error');
    errorFields.forEach(field => field.textContent = '');
}

function displayError(errorFieldId, errorMessage) {
    const errorField = document.getElementById(errorFieldId);
    if (errorField) {
        errorField.textContent = errorMessage;
        errorField.style.color = 'red';
    }
}

function validateForm(form) {
    let isValid = true;

    // Validate first name
    const firstName = form.elements['first_name'].value.trim();
    if (firstName === '') {
        displayError('first_name_error', 'Please fill in your first name');
        isValid = false;
    }

    // Validate last name
    const lastName = form.elements['last_name'].value.trim();
    if (lastName === '') {
        displayError('last_name_error', 'Please fill in your last name');
        isValid = false;
    }

    // Validate email
    const email = form.elements['email'].value.trim();
    if (email === '') {
        displayError('email_error', 'Please enter your email');
        isValid = false;
    } else if (!validateEmail(email)) {
        displayError('email_error', 'Your email is invalid');
        isValid = false;
    }

    // Validate phone number
    const phoneNumber = form.elements['phone_number'].value.trim();
    if (phoneNumber === '') {
        displayError('phone_error', 'Please enter your phone number');
        isValid = false;
    } else if (!validatePhoneNumber(phoneNumber)) {
        displayError('phone_error', 'Phone number can only be numbers and must be 10 digits');
        isValid = false;
    }

    // Validate password
    const password = form.elements['password'].value.trim();
    const confirmPassword = form.elements['confirm_password'].value.trim();
    if (password === '') {
        displayError('password_error', 'Please enter your password');
        isValid = false;
    } else if (!validatePassword(password)) {
        displayError('password_error', 'Password must contain at least one capital letter, numbers, and special characters');
        isValid = false;
    } else if (confirmPassword !== password) {
        displayError('confirm_password_error', 'Confirm password and your password must match');
        isValid = false;
    }

    return isValid;
}

function validateEmail(email) {
    const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return emailRegex.test(email);
}

function validatePhoneNumber(phoneNumber) {
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(phoneNumber);
}

function validatePassword(password) {
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/;
    return passwordRegex.test(password);
}

function sendData(form) {
    const ajax = new XMLHttpRequest();
    const toastBox = document.getElementById('toast_box');
    ajax.addEventListener('readystatechange', function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                const toast = document.createElement('div');
                toast.className = 'toast';
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.innerHTML = `
                <div class="toast-header">
                    <strong class="me-auto">Signup Successful</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Verify your Email to Continue
                </div>
                `;
                toastBox.appendChild(toast);
                const bootstrapToast = new bootstrap.Toast(toast);
                bootstrapToast.show();
            } else {
                console.log(ajax);
                alert("An error has occurred")
            }
        }
    });
    ajax.open('POST', 'ajax.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    // Serialize form data manually
    const formData = new URLSearchParams();
    for (const pair of form.entries()) {
        formData.append(pair[0], pair[1]);
    }

    // Send serialized form data
    ajax.send(formData.toString()); 
}
