import { required, validForm } from "Services/Validation";

export const validOnSubmit = validForm({
    oldPassword: [required],
    password: [required],
    passwordRepeat: [required],
});