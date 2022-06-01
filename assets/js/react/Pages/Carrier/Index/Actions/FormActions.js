import Constants from '../Constants';

export const onChange = (dispatch) => (key) => (value) => {
    dispatch({ type: Constants.CHANGE_FORM, data: { key, value } });
};

export const changeShowIndex = (dispatch) => (showIndex) => {
    dispatch({ type: Constants.CHANGE_SHOW, data: { showIndex } });
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
            return false;
        };

export const onResetForm = (dispatch) => () => {
    dispatch({ type: Constants.FORM_RESET });
};

export const updateCarrier = (dispatch, { service }) => async () => {
    const { getCarriers } = service;
    const data = await getCarriers();

    dispatch({ type: Constants.FORM_UPDATE, data });
};

export const createCarrier = (dispatch, { service }) => (item) => {
    const { save } = service;
    return  save('create', item);
};

export const editCarrier = (dispatch, { service }) => (item) => {
    const { save } = service;
    return save(`${item.id}/edit`, item);
};

export const deleteCarrier = (dispatch, { service }) => (item) => {
    const { deleteItem } = service;
    return deleteItem(`${item.id}/delete`, item);
};

