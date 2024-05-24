import ToastHandler from './toastHandler.js';

export default class AjaxCalls {
    constructor(form, dataType, displayMessageDiv) {
        this.dataType = dataType;
        this.form = form;
        this.displayMessageDiv = displayMessageDiv;
        this.ajax = new XMLHttpRequest();
    }

    sendData() {
        const formData = new FormData(this.form);
        formData.append('data_type', this.dataType);

        this.ajax.addEventListener('readystatechange', () => {
            if (this.ajax.readyState === 4) {
                if (this.ajax.status === 200) {
                    try {
                        const response = JSON.parse(this.ajax.responseText);
                        this.handleResponse(response);
                    } catch (error) {
                        this.displayErrorToast('An error has occurred');
                    }
                } else {
                    this.displayErrorToast('An error has occurred');
                }
            }
        });

        this.ajax.open('POST', 'ajax.php', true);
        this.ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        this.ajax.send(new URLSearchParams(formData).toString());
    }

    displayErrorToast(message) {
        const errorToast = new ToastHandler(message, this.displayMessageDiv);
        errorToast.displayToast();
    }

    handleResponse(response){
        console.log(response);

        if(response.success){
            const successMsg = response.message;
            const successToast = new ToastHandler(successMsg, this.displayMessageDiv);
            successToast.displayToast();
            this.form.reset();
        }else {
            const errMsg = response.message || "An error has occured";
            this.displayErrorToast(errMsg);
        }
    }
}
