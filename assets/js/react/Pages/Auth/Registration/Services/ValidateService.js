import { required, validForm, email } from "Services/Validation";

export const validOnSubmit = validForm({
    email: [required, email],
});