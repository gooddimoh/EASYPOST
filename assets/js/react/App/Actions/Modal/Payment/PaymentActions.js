import { curry } from 'ramda';
import Constants from '../../../Constants/Modal/Payment';
import { getBalance } from '../../../Services/Modal';

export const initPaymentModal = (dispatch) => (data) => {
    dispatch({ type: Constants.PAYMENT_MODAL_INIT, data });
};

export const onChangePayment = (dispatch) =>
    curry((key, value) => {
        dispatch({ type: Constants.PAYMENT_MODAL_CHANGE, data: { key, value } });
    });

export const requestGetBalance = (dispatch) => async () => {
    const data = await getBalance();
    dispatch({ type: Constants.FETCH_BALANCE, data });
};

export const validateForm =
    (dispatch, { service }) =>
    (formData, onResolve) => {
        const { validOnSubmit } = service;
        const data = validOnSubmit(formData);

        if (!data.formValidate) {
            dispatch({ type: Constants.PAYMENT_VALIDATE_FORM, data });
            return;
        }

        onResolve();
    };
