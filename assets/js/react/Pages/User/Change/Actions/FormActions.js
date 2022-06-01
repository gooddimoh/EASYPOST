import Constants from '../Constants';

export const onChange = (dispatch) => (key) => (value) => {
    dispatch({ type: Constants.CHANGE_FORM, data: { key, value } });
};

export const submitFormAction =
    (dispatch, { service }) =>
    async (data, id) => {
        dispatch({ type: Constants.FORM_REQUESTED });

        try {
            const result = await service.requestOnSubmit(id)(data);
            dispatch({ type: Constants.FORM_SUCCEEDED });
            return result;
        } catch (error) {
            dispatch({ type: Constants.FORM_FAILED, data: error });
        }

        return null;
    };

export const onResetForm = (dispatch) => () => {
    dispatch({ type: Constants.FORM_RESET });
};

export const validateForm = (dispatch) => validator => (formData, onResolve) => {
    const data = validator(formData);
    if (!data.formValidate) {
        dispatch({ type: Constants.VALIDATE_FORM, data });
        return;
    }

    onResolve();
};
