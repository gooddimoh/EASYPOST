import { changeForm } from 'Services/Store';
import Constants from '../Constants';

export const initState = {
    firstName: '',
    lastName: '',
    email: '',
    packagePlan: '',
    company: '',
    role: '',
    type: '',


    street1: '',
    typeAddress: '',
    city: '',
    state: '',
    zip: '',
    street2: '',
    country: 'US',
    code: '',
    phone: '',

    formValidate: false,
    formLoading: false,
    formErrors: {},
};


export const reducer = {
    [Constants.CHANGE_FORM]: changeForm,
    [Constants.VALIDATE_FORM]: ({ data }) => data,
    [Constants.FORM_REQUESTED]: () => ({ formLoading: true }),
    [Constants.FORM_SUCCEEDED]: () => ({ formLoading: false }),
    [Constants.FORM_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),
    [Constants.FORM_RESET]: () => initState,
};