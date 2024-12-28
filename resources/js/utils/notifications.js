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

const showSuccessToast = (title, timer) => {
    showToast('success', title, timer);
};

const showErrorToast = (title, timer) => {
    showToast('error', title, timer);
};

export { showSuccessToast, showErrorToast };
