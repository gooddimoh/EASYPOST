import { required, validForm, email, numbers } from 'Services/Validation';

const validOnSubmit = validForm({
    name: [required],
    type: [required],
    code: [required],
    phone: [numbers],
    email: [email],
    street1: [required],
    city: [required],
    zip: [required],
    state: [required],
    country: [required],
    minDate: [required],
    maxDate: [required],
    instructions: [required],
});

export { validOnSubmit };
