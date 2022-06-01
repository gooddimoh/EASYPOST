import Constants from 'App/Constants/Modal/Label';

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
    statusEnumColorOptions: {},
};

export const reducer = {
    [Constants.LABEL_FORM_REQUESTED]: () => ({ formLoading: true }),
    [Constants.LABEL_FORM_RESET]: ({ state }) => ({ label: initState, type: state.label.type }),
    [Constants.LABEL_FORM_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),
    [Constants.LABEL_FORM_SUCCEEDED]: ({ state, data }) => ({
        formLoading: false,
        label: { ...state.label, labelId: data, rateId: '' },
    }),

    [Constants.PICKUP_FORM_REQUESTED]: () => ({ formLoading: true }),
    [Constants.PICKUP_FORM_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),
    [Constants.PICKUP_FORM_SUCCEEDED]: ({ state, data }) => ({
        formLoading: false,
        label: { ...state.label, ...data },
    }),
};
