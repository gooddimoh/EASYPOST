import { generateKeyRender, throwError } from 'Services';
import { labelResponseNormalizer } from 'App/View/Modal/Label/Services/DataService';
import Constants from 'App/Constants/Modal/Label';

export const requestGetRates =
    (dispatch, { service }) =>
    async (data) => {
        dispatch({ type: Constants.RATES_REQUESTED });
        try {
            const result = await service.requestRates(data);
            dispatch({
                type: Constants.RATES_SUCCEEDED,
                data: generateKeyRender({
                    ...result,
                    sender: data.sender,
                    recipient: data.recipient,
                    type: data.type,
                    weight: data.weight,
                    pickup: data.pickup,
                    packages: data?.packages,
                    parcel: data.parcel,
                }),
            });
            return result;
        } catch (error) {
            dispatch({ type: Constants.RATES_FAILED, data: error });
        }
        return false;
    };

export const submitFormAction =
    (dispatch, { service }) =>
    async (data) => {
        dispatch({ type: Constants.LABEL_FORM_REQUESTED });
        try {
            const result = await service.requestOnSubmit(data);
            dispatch({ type: Constants.LABEL_FORM_SUCCEEDED, data: result.id });
            return result;
        } catch (error) {
            throwError(error);
            dispatch({ type: Constants.LABEL_FORM_FAILED, data: error });
        }
        return false;
    };

export const submitPickupAction =
    (dispatch, { service }) =>
    async (url, data) => {
        dispatch({ type: Constants.PICKUP_FORM_REQUESTED });
        try {
            const result = await service.requestOnSubmitPickup(url, data);
            dispatch({ type: Constants.PICKUP_FORM_SUCCEEDED, data: generateKeyRender(result) });
            return result;
        } catch (error) {
            throwError(error);
            dispatch({ type: Constants.PICKUP_FORM_FAILED, data: error });
        }
        return false;
    };

export const requestGetPickup =
    (dispatch, { service }) =>
    async (url, data) => {
        dispatch({ type: Constants.RATES_REQUESTED });
        try {
            const result = await service.requestPickup(url, data);
            dispatch({ type: Constants.RATES_SUCCEEDED, data: result });
            return result;
        } catch (error) {
            throwError(error);
            dispatch({ type: Constants.RATES_FAILED, data: error });
        }
        return false;
    };

export const onChangePickup = (dispatch) => (key, value) => {
    dispatch({ type: Constants.CHANGE_PICKUP_FORM, data: { key, value } });
};

export const clearLabelState = (dispatch) => () => {
    dispatch({ type: Constants.CLEAR_LABEL_STATE });
};

export const onChangeRate = (dispatch) => (id) => {
    dispatch({ type: Constants.CHANGE_RATE, data: { id } });
};

export const nextModalScreen = (dispatch) => () => {
    dispatch({ type: Constants.CHANGE_MODAL_SCREEN });
};

export const goToScreen = (dispatch) => (name) => {
    dispatch({ type: Constants.DEFAULT_MODAL_SCREEN, data: name });
};

export const validatePickupForm =
    (dispatch, { service }) =>
    (formData, onResolve) => {
        const { validOnSubmit } = service;
        const data = validOnSubmit(formData);

        if (!data.formValidate) {
            dispatch({ type: Constants.VALIDATE_PICKUP_FORM, data });
            return;
        }

        onResolve();
    };

export const getLabelInfo =
    (dispatch, { service }) =>
    async (id) => {
        const [data] = await service.requestLabelInfo(id);

        dispatch({
            type: Constants.SET_LABEL_DATA,
            data: labelResponseNormalizer(data),
        });

        return !!data;
    };
