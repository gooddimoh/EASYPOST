import { required, validForm, email } from 'Services/Validation';

export const validOnSubmit = validForm({
    name: [required],
    street1: [required],
    email: [email],
    typeAddress: [required],
    city: [required],
    state: [required],
    zip: [required],
    street2: [required],
    country: [required],
    phone: [required],
    code: [required],
    description: [required],
});
