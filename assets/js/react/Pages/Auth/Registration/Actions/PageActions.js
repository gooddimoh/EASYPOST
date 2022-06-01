import Constants from '../Constants';

export const onChange = (dispatch) => (key) => (value) => {
    dispatch({ type: Constants.CHANGE_FORM, data: { key, value } });
};

export const submitFormAction =
    (dispatch, { service }) =>
    async (data) => {
        const { userRequest } = service;

        dispatch({ type: Constants.FORM_REQUESTED });

        try {
            const redirect = await userRequest({ ...data});

            dispatch({ type: Constants.FORM_SUCCEEDED });

            return redirect;
        } catch (error) {
            dispatch({ type: Constants.FORM_FAILED, data: error });
        }

        return null;
    };

export const onResetForm = (dispatch) => () => {
    dispatch({ type: Constants.FORM_RESET });
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
