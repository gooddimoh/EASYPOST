import {required, validForm} from "Services/Validation";
import {carriersType} from 'Services/Enums';
import {schemaCall} from "Services";

const validOnSubmitUps = {
    access_license_number: [required],
    account_number: [required],
    user_id: [required],
    password: [required],
};

const validOnSubmitFedex = {
    account_number: [required],
    meter_number: [required],
    key: [required],
    password: [required],
};

const options = schemaCall({
    [carriersType.ups]: validForm(validOnSubmitUps),
    [carriersType.fedex]: validForm(validOnSubmitFedex),
});

const validOnSubmit = ({ type, credentials }) => options(type, credentials);

export {validOnSubmit};
