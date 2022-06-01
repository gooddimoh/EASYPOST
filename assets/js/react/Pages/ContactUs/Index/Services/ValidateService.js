import {required, validForm} from 'Services/Validation';

const validOnSubmit = validForm({
    full_name: [required],
    email: [required],
    message: [required],
});

export {validOnSubmit};
