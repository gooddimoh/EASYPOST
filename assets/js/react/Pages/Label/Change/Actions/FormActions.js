import Constants from '../Constants';

export const onChange = (dispatch) => (key, value) => {
    dispatch({ type: Constants.CHANGE_FORM, data: { key , value } });
};

export const onChangePackage = (dispatch) => (key, id, value) => {
    dispatch({ type: Constants.CHANGE_FORM_PACKAGE, data: { key, id, value } });
};

export const onCalculateOptions = (dispatch) => (data) => {
    dispatch({ type: Constants.CALCULATE_PACKAGE_OPTIONS, data });
};

export const onResetForm = (dispatch) => () => {
    dispatch({ type: Constants.FORM_RESET });
};

export const addItem = (dispatch) => (data) => {
    dispatch({ type: Constants.ADD_ITEM, data });
};

export const deleteItem = (dispatch) => (id) => {
    dispatch({ type: Constants.DELETE_ITEM, data: id });
};

export const requestAddressById =
    (dispatch, { service }) =>
    async (filter, key) => {
        dispatch({ type: Constants.ADDRESS_DATA_REQUESTED });
        try {
            const data = await service.requestAddressBooksById(filter);
            dispatch({ type: Constants.ADDRESS_DATA_SUCCEEDED, data: { key, data } });
            return data;
        } catch (error) {
            dispatch({ type: Constants.ADDRESS_DATA_FAILED, data: error });
        }
        return false;
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
            dispatch({ type: Constants.VALIDATE_FORM, data });
            return;
        }

        onResolve();
    };
