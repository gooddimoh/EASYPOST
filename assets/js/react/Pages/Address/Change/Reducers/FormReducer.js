import { changeForm } from 'Services/Store';
import Constants from '../Constants';

export const initState = {
    name: '',
    street1: '',
    type: '',
    typeAddress: '',
    city: '',
    state: '',
    zip: '',
    street2: '',
    country: 'US',
    code: '',
    phone: '',
    email: '',
    description: '',
    formValidate: false,
    formErrors: {},
};

export const reducer = {
    [Constants.CHANGE_FORM]: changeForm,
    [Constants.VALIDATE_FORM]: ({ data }) => data,
    [Constants.FORM_RESET]: ({ state }) => ({ ...initState, type: state.type }),
};
