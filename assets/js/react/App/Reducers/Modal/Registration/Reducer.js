import { changeForm } from 'Services/Store';
import Constants from '../../../Constants/Modal/Registration';

export const initState = {
    name: '',
    email: '',

    company: '',
    type: '',

    street1: '',
    typeAddress: '',
    country: 'US',
    state: '',
    city: '',
    zip: '',

    code: '',
    phone: '',

    formValidate: false,
    formLoading: false,
    formErrors: {},
};

const changeSomeFields = (arr, initialState) =>
    Object.keys(arr).reduce((acc, current) => {
        acc = changeForm({ state: acc, data: { key: current, value: arr[current] } });
        return acc;
    }, initialState);

export const reducer = {
    [Constants.CHANGE_REGISTRATION_FORM]: ({ state, data }) => ({
        registration: changeForm({ state: state.registration, data }),
    }),
    [Constants.PRE_FILL_REGISTRATION_FORM]: ({ state, data }) => ({
        registration: changeSomeFields(data, state.registration),
    }),
    [Constants.VALIDATE_REGISTRATION_FORM]: ({ state, data }) => ({ registration: { ...state.registration, ...data } }),
};
