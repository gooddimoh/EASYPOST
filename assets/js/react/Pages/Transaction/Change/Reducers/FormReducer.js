import { changeForm } from "Services/Store";
import { paymentType } from "Services/Enums";
import Constants from '../Constants';

export const initState = {
    id: '',
    date: '',
    balance: '',
    method: paymentType.admin,
    description: '',
    company: '',
    options: [],

    validate: false,
    loading: false,
    errors: {},
};

export const reducer = {
    [Constants.CHANGE_FORM]: changeForm,
    [Constants.VALIDATE_FORM]: ({ data }) => data,
    [Constants.FORM_REQUESTED]: () => ({ loading: true }),
    [Constants.FORM_SUCCEEDED]: () => ({ loading: false }),
    [Constants.FORM_FAILED]: ({ data }) => ({ errors: data, loading: false }),
    [Constants.FORM_RESET]: () => initState,
};
