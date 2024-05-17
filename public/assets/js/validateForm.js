import ToastHandler from './toastHandler.js';

export default class ValidateForm{
    constructor(element, displayDiv){
        this.element = element
        this.displayDiv = document.getElementById(displayDiv);
    }

    validateName(){
        const name = this.element.value.trim();
        if(name === "" || name === null){
            const error = new ToastHandler(`Please fill in your Name`, this.displayDiv);
            error.displayFormError();
        }else if(name.length > 50)
        {
            const error = new ToastHandler(`Your ${name} is too long`, this.displayDiv);
            error.displayFormError();
        }
        return true;
    }

    validateEmail(){
        const email = this.element.value.trim();
        if(email === "" || email === null){
            const error = new ToastHandler(`Please fill in your Email`, this.displayDiv);
            error.displayFormError();
        }else if(email.length > 99)
        {
            const error = new ToastHandler(`Your Email is too long`, this.displayDiv);
            error.displayFormError();
        }

        return true;
    }

    validatePassword(){
        const password = this.element.value.trim();
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/;
        if(password === '' || password === null){
            const error = new ToastHandler(`Please fill in your Password`, this.displayDiv);
            error.displayFormError();
        }else if(!passwordRegex.test(password))
        {
            const error = new ToastHandler(`Password must contain at least one capital letter, one number & one symbol`, this.displayDiv);
            error.displayFormError();
        }
        return true;
    }
}