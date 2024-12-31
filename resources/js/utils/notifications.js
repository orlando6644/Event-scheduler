import Swal from 'sweetalert2';

const showToast = (icon, title, timer = 4000) => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
};

const eventUpdateToast = (icon, title, timer = 6000) => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
};

const showConfirmationDialog = async (title, text, confirmButtonText = 'Yes, delete it!') => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancel'
    });
};

const showSuccessToast = (title, timer) => {
    showToast('success', title, timer);
};

const showErrorToast = (title, timer) => {
    showToast('error', title, timer);
};

const showEventUpdateToast = (title, timer) => {
    eventUpdateToast('info', title, timer);
};

export { showSuccessToast, showErrorToast, showEventUpdateToast, showConfirmationDialog };
