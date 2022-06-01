import Constants from '../../../Constants/Modal/Registration';

export const onChange = (dispatch) => (key) => (value) => {
    dispatch({ type: Constants.CHANGE_REGISTRATION_FORM, data: { key, value } });
};

export const preFill = (dispatch) => (arr) => {
    dispatch({ type: Constants.PRE_FILL_REGISTRATION_FORM, data: arr });
};

export const validateForm =
    (dispatch, { service }) =>
    (formData, onResolve) => {
        const { validOnSubmit } = service;

        const data = validOnSubmit(formData);

        if (!data.formValidate) {
            dispatch({ type: Constants.VALIDATE_REGISTRATION_FORM, data });
            return;
        }

        onResolve();
    };

export const onSubmitForm =
    (dispatch, { service }) =>
    async (data) => {
        const { id } = await service.requestRegistration(data);
        if (id) {
            dispatch({ type: Constants.REGISTRATION_CONFIRMED });
            return id;
        }

        return null;
    };
