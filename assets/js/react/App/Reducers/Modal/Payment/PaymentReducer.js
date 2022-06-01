import { changeForm } from 'Services/Store';
import Constants from '../../../Constants/Modal/Payment';

export const initState = {
    form: {
        method: '',
        amount: '50',
    },
    formValidate: false,
    formErrors: {},
};

export const reducer = {
    [Constants.PAYMENT_MODAL_INIT]: ({ data }) => ({ payment: data }),
    [Constants.PAYMENT_MODAL_CHANGE]: changeForm,
    [Constants.PAYMENT_VALIDATE_FORM]: ({ state, data }) => ({ payment: { ...state.payment, ...data } }),
};
