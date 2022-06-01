import { pathOr } from 'ramda';
import { addressBookType } from 'Services/Enums';

const validateFormData = (form) => ({
    name: pathOr('', ['name', 'value'], form),
    email: pathOr('', ['email', 'value'], form),
    packagePlan: pathOr('', ['packagePlan', 'value'], form),
    company: pathOr('', ['company', 'value'], form),
    type: pathOr('', ['type', 'value'], form),
    street1: pathOr('', ['street1', 'value'], form),
    typeAddress: pathOr('', ['typeAddress', 'value'], form),
    country: pathOr('', ['country', 'value'], form),
    state: pathOr('', ['state', 'value'], form),
    city: pathOr('', ['city', 'value'], form),
    zip: pathOr('', ['zip', 'value'], form),
    code: pathOr('', ['code', 'value'], form),
    phone: pathOr('', ['phone', 'value'], form),
});

const formData = (form) => ({
    name: pathOr('', ['name', 'value'], form),
    email: pathOr('', ['email', 'value'], form),
    code: pathOr('', ['code', 'value'], form),
    phone: pathOr('', ['phone', 'value'], form),
    company_name: pathOr('', ['company', 'value'], form),
    company_type: pathOr('', ['type', 'value'], form),
    street1: pathOr('', ['street1', 'value'], form),
    type_address: pathOr('', ['typeAddress', 'value'], form),
    city: pathOr('', ['city', 'value'], form),
    state: pathOr('', ['state', 'value'], form),
    zip: pathOr('', ['zip', 'value'], form),
    country: pathOr('', ['country', 'value'], form),
    type: addressBookType.sender,
});

export { validateFormData, formData };
