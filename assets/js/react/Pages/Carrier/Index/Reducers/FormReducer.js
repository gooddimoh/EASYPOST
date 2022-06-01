import { T, where } from 'ramda';
import { validFormOnChange as _validFormOnChange } from 'Services/Validation';
import Constants from '../Constants';

export const initState = {
    showIndex: -1,

    formValidate: false,
    formLoading: false,
    formErrors: {},
};

const validState = _validFormOnChange(
    where({
        showIndex: T,
    }),
);

export const reducer = {
    [Constants.CHANGE_FORM]: validState,
    [Constants.FORM_UPDATE]: ({ data }) => data,
    [Constants.CHANGE_SHOW]: ({ data }) => data,
    [Constants.FORM_REQUESTED]: () => ({ formLoading: true }),
    [Constants.FORM_SUCCEEDED]: () => ({ formLoading: false }),
    [Constants.FORM_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),
    [Constants.FORM_RESET]: () => initState,
};
