import Swal from 'https://cdn.skypack.dev/sweetalert2';

/**
 * Displays a success alert with a custom message.
 * @param {*} message The message to display in the success alert.
 */
export const successAlert = (message) => {
    Swal.fire({
        icon: "success",
        title: message,
        confirmButtonColor: "#5DB075",
        timer: 2000,
        timerProgressBar: true,
    });
};

/**
 * Displays an error alert with a custom message.
 * @param {*} message The message to display in the error alert.
 */
export const errorAlert = (message) => {
    Swal.fire({
        icon: "error",
        title: message,
        confirmButtonColor: "#d33",
        timer: 2000,
        timerProgressBar: true,
    });
};

/**
 * Shows a confirmation dialog with a question, and executes a provided action if confirmed.
 * @param {*} question The question to ask in the confirmation dialog.
 * @param {*} action The function to execute if the user confirms.
 * @param  {...any} actionArgs Arguments to pass to the `action` function.
 */
export const confirmAlert = (question, action, ...actionArgs) => {
    Swal.fire({
        title: question,
        showDenyButton: true,
        confirmButtonText: "Yes",
        denyButtonText: "No",
        confirmButtonColor: "#009743",
        denyButtonColor: "#0b6131",
    }).then((result) => {
        if (result.isConfirmed) {
            action(...actionArgs);
        }
    });
};
