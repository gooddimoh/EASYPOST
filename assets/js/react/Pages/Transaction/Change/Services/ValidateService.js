import { required, validForm, money } from "Services/Validation";

export const validOnSubmit = validForm({
    balance: [required, money],
    description: [required],
    company: [required],
});
