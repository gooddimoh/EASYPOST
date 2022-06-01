import { required, validForm, email, numbers, arrayOf, requireAll } from 'Services/Validation';
import { labelType } from 'Services/Enums';

const validateAddress = {
    name: [required],
    type: [required],
    code: [required],
    phone: [required, numbers],
    email: [email],
    street1: [required],
    city: [required],
    state: [required],
    country: [required],
    zip: [required],
};

const commonFields = {
    type: [required],
    weight: [numbers],
    parcel: requireAll({
        length: [numbers],
        width: [numbers],
        height: [numbers],
    }),
};

const validStateWorld = {
    sender: validateAddress,
    recipient: validateAddress,
    packages: arrayOf({
        description: [required],
        quantity: [numbers],
        weight: [numbers],
        price: [numbers],
    }),
    price: [numbers],
    ...commonFields,
};

const validStateLocal = {
    sender: validateAddress,
    recipient: validateAddress,
    ...commonFields,
};

const validOnSubmit = (data) => {
    const { type } = data;

    const options = {
        [labelType.world]: validStateWorld,
        [labelType.local]: validStateLocal,
    };

    return validForm(options[type])(data);
};

export { validOnSubmit };
