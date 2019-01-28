import miniToastr from 'mini-toastr';

miniToastr.init();

export default {
    success(title, message) {
        miniToastr.success(message, title);
    },
    error(title, message) {
        miniToastr.error(message, title);
    },
    warn(title, message) {
        miniToastr.warn(message, title);
    },
    info(title, message) {
        miniToastr.info(message, title);
    }
}
