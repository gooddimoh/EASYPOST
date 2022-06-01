import Constants from '../Constants';
import { validOnSubmit } from "../Services/ValidateService";

export const onChange = (dispatch) => (key) => (value) => {
    dispatch({ type: Constants.CHANGE_FORM, data: { key, value } });
};

export const submitFormAction = (dispatch, { service }) => async (data) => {

    dispatch({ type: Constants.FORM_REQUESTED });
    try {
        const result = await service.requestOnSubmit(data);
        dispatch({ type: Constants.FORM_SUCCEEDED });
        return result;
    } catch (error) {
        dispatch({ type: Constants.FORM_FAILED, data: error });
    }
    return false;
};

export const onResetForm = (dispatch) => () => {
    dispatch({ type: Constants.FORM_RESET });
};

export const validateForm = (dispatch) => (formData, onResolve) => {

    const data = validOnSubmit(formData);

    if (!data.formValidate) {
        dispatch({ type: Constants.VALIDATE_FORM, data });
        return;
    }

    onResolve();
};