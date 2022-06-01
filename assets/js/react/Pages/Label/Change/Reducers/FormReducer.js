import { toString } from 'ramda';
import { changeForm } from 'Services/Store';
import Constants from '../Constants';

export const mainAddressData = {
    name: '',
    type: '1',
    code: '',
    phone: '',
    email: '',
    street1: '',
    street2: '',
    city: '',
    state: '',
    country: 'US',
    zip: '',
};

export const initState = {
    sender: { id: '', ...mainAddressData },
    recipient: { id: '', ...mainAddressData },

    packages: [],

    type: null,
    price: '',
    weight: '',

    parcel: {
        length: '',
        width: '',
        height: '',
    },

    pickup: [],

    formValidate: false,
    formLoading: false,
    formErrors: {},
};

const changePackages = (packages, { key, id, value }) => {
    return packages.map((elem) => (elem._id === id ? { ...elem, [key]: value } : elem));
};

const deletePackage = (packages, id) => packages.filter((elem) => elem._id !== id);

export const reducer = {
    [Constants.CHANGE_FORM]: changeForm,
    [Constants.VALIDATE_FORM]: ({ data }) => data,
    [Constants.CALCULATE_PACKAGE_OPTIONS]: ({ data }) => data,
    [Constants.FORM_REQUESTED]: () => ({ formLoading: true }),
    [Constants.ADDRESS_DATA_REQUESTED]: () => ({ formLoading: true }),
    [Constants.FORM_RESET]: ({ state }) => ({ ...initState, type: state.type }),
    [Constants.LABEL_FORM_RESET]: ({ state }) => ({ ...initState, type: state.type }),
    [Constants.FORM_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),
    [Constants.ADDRESS_DATA_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),

    [Constants.ADD_ITEM]: ({ state, data }) => ({ packages: [data, ...state.packages] }),
    [Constants.DELETE_ITEM]: ({ state, data }) => ({ packages: deletePackage(state.packages, data) }),
    [Constants.CHANGE_FORM_PACKAGE]: ({ state, data }) => ({ packages: changePackages(state.packages, data) }),

    [Constants.ADDRESS_DATA_SUCCEEDED]: ({ state, data }) => ({
        [data.key]: { ...state[data.key], ...data.data, type: toString(data.data.type_address) },
        formLoading: false,
    }),
};
