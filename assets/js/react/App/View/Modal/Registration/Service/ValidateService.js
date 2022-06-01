import { required, validForm, moreThanOne } from 'Services/Validation';

export const validOnSubmit = validForm({
    name: [required, moreThanOne],
    company: [required],
    street1: [required],
    typeAddress: [required],
    country: [required],
    state: [required],
    city: [required],
    zip: [required],
    code: [required],
    phone: [required],
});
