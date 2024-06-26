import ValidateForm from './validateForm.js';
import AjaxCalls from './ajaxCalls.js';

const signupForm = document.getElementById('signupForm');
const submitBtn = document.getElementById('sign-up-submit');

if(submitBtn){
    submitBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if(!validateForm(signupForm)){
            return;
        }
        const ajaxBox = document.getElementById('ajax-response');
        const ajax = new AjaxCalls(signupForm, 'signup', ajaxBox);
        ajax.sendData();
    });
}


const loginForm = document.getElementById('loginForm');
const loginBtn = document.getElementById('loginBtn');

if(loginBtn){
    loginBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if(validateLogin(loginForm)){
           return
        } 
        const ajaxBox = document.getElementById('ajax-response');
        const ajax = new AjaxCalls(loginForm, 'login', ajaxBox);
        ajax.sendData();
    });
}



function validateForm(form){

    let isValid = true;

    //Validate first name
    const firstName = document.getElementById('first_name');
    const firstNameTest = new ValidateForm(firstName, 'first_name_error');
    if(!firstNameTest.validateName()){
        isValid = false;
    }
    //Validate second name
    const secondName = document.getElementById('last_name');
    const secondNameTest = new ValidateForm(secondName, 'last_name_error');
    if(!secondNameTest.validateName()){
        isValid = false;
    }
    //Validate email
    const email = document.getElementById('email');
    const emailTest = new ValidateForm(email, 'email_error');
    if(!emailTest.validateEmail()){
        isValid = false;
    }
    //validate password
    const pass = document.getElementById('password');
    const passwordTest = new ValidateForm(pass, 'password_error');
    if(!passwordTest.validatePassword()){
        isValid = false;
    }
    return isValid;
}

function validateLogin(form)
{
    const email = document.getElementById('email');
    const emailTest = new ValidateForm(email, 'email_error');
    if(!emailTest.validateEmail()){
        isValid = false;
    }
}