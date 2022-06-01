import { changeForm } from 'Services/Store';
import Constants from '../Constants';

export const initState = {
    full_name: '',
    message: '',
    email: '',
    check: [],

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
