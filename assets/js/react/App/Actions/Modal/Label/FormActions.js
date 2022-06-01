import Constants from 'App/Constants/Modal/Label';

export const onChange = (dispatch) => (key, value) => {
    dispatch({ type: Constants.CHANGE_FORM, data: { key, value } });
};

export const onChangePackage = (dispatch) => (key, id, value) => {
    dispatch({ type: Constants.CHANGE_FORM_PACKAGE, data: { key, id, value } });
};

export const onCalculateOptions = (dispatch) => (data) => {
    dispatch({ type: Constants.CALCULATE_PACKAGE_OPTIONS, data });
};

export const onResetForm = (dispatch) => () => {
    dispatch({ type: Constants.LABEL_FORM_RESET });
};

export const addItem = (dispatch) => (data) => {
    dispatch({ type: Constants.ADD_ITEM, data });
};

export const deleteItem = (dispatch) => (id) => {
    dispatch({ type: Constants.DELETE_ITEM, data: id });
};

export const fillPickupForm = (dispatch) => () => {
    dispatch({ type: Constants.FILL_PICKUP_FORM });
};

export const validateForm =
    (dispatch, { service }) =>
    (formData, onResolve) => {
        const { validOnSubmit } = service;
        const data = validOnSubmit(formData);

        if (!data.formValidate) {
            dispatch({ type: Constants.VALIDATE_MODAL_FORM, data });
            return;
        }

        onResolve();
    };
