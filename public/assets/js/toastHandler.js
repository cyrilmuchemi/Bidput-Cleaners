export default class ToastHandler{
    constructor(message, displayDiv){
        this.message = message;
        this.displayDiv = displayDiv;
    }

    displayToast(){
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="toast-header">
            <strong class="me-auto">Message</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${this.message}
            </div>
        `;
        const bootstrapToast = new bootstrap.Toast(toast);
        this.displayDiv.appendChild(toast); 
        bootstrapToast.show();
    }

    displayFormError(){
        const errorField = this.displayDiv;
        if(errorField){
            errorField.textContent = this.message;
            errorField.style.color = 'red';
        }
    }
}