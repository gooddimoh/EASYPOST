import { money, numbers, required, validForm } from "Services/Validation";

export const validOnSubmit = validForm({
    name: [required],
    price_label: [required, numbers, money],
    price_month: [required, numbers, money],
    price_additional: [required, numbers, money],
});