import { required, validForm } from 'Services/Validation';

export const validOnSubmit = validForm({
    name: [required],
    type: [required],
});
