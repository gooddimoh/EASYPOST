import { required, validForm } from 'Services/Validation';

export const validOnSubmit = validForm({
    title: [required],
    description: [required],
    link: [required],
    photo: [required],
});
