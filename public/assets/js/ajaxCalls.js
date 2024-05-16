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
                        if (response.success !== undefined && response.text !== undefined) {
                            const message = new ToastHandler(response.text, this.displayMessageDiv);
                            message.displayToast();
                            if (response.success) {
                                this.form.reset();
                            }
                        } else {
                            console.error('Invalid JSON response:', response);
                            this.displayErrorToast('An error has occurred');
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        this.displayErrorToast('An error has occurred');
                    }
                } else {
                    console.error('Error occurred:', this.ajax.status);
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
}
