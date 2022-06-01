import { required, validForm, email, moreThanOne } from 'Services/Validation';

export const validOnSubmit = validForm({
    name: [required, moreThanOne],
    email: [email],
    company: [required],
    role: [required],
});
