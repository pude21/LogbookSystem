/**
 * The **`serializeForm`** function converts form data into a JavaScript object.
 * @param {*} form The form element to be serialized into an object.
 * @returns the resulting object with form field names as keys and their corresponding values.
 */
const serializeForm = (form) => {
    const formData = new FormData(form);
    const object = {};
    formData.forEach((value, key) => {
        object[key] = value;
    });
    return object;
};

export default serializeForm;