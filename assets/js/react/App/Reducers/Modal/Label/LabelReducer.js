import { schemaCall } from 'Services';
import { changeForm } from 'Services/Store';
import { modalViewsEnum } from 'Services/Enums';
import Constants from 'App/Constants/Modal/Label';
import { mainAddressData } from './FormReducer';

export const getNextScreen = schemaCall({
    [modalViewsEnum.labelRates]: (opt) => (opt.includes('pickup') ? modalViewsEnum.pickupForm : modalViewsEnum.success),
    [modalViewsEnum.pickupForm]: () => modalViewsEnum.pickupRates,
    [modalViewsEnum.pickupRates]: () => modalViewsEnum.success,
});

export const initState = {
    columns: [],
    items: [],
    pagination: {},
    shipmentId: '',
    rateId: '',
    labelId: '',
    currentScreen: modalViewsEnum.labelRates,

    pickupForm: {
        ...mainAddressData,
        minDate: '',
        maxDate: '',
        instructions: '',
        useSender: [],
    },

    formValidate: false,
    formErrors: {},
};

export const reducer = {
    [Constants.RATES_SUCCEEDED]: ({ state, data }) => ({ label: { ...state.label, ...data } }),
    [Constants.CHANGE_RATE]: ({ state, data }) => ({ label: { ...state.label, rateId: data.id } }),
    [Constants.VALIDATE_PICKUP_FORM]: ({ state, data }) => ({ label: { ...state.label, ...data } }),
    [Constants.DEFAULT_MODAL_SCREEN]: ({ state, data }) => ({ label: { ...state.label, currentScreen: data } }),

    [Constants.CHANGE_MODAL_SCREEN]: ({ state }) => {
        const next = getNextScreen(state.label.currentScreen, state.label.pickup);
        return { label: { ...state.label, currentScreen: next } };
    },
    [Constants.FILL_PICKUP_FORM]: ({ state }) => ({
        label: {
            ...state.label,
            pickupForm: {
                ...state.label.pickupForm,
                ...state.label.sender,
            },
        },
    }),
    [Constants.CHANGE_PICKUP_FORM]: ({ state, data }) => {
        return {
            label: {
                ...state.label,
                pickupForm: changeForm({ state: state.label.pickupForm, data }),
            },
        };
    },
    [Constants.SET_LABEL_DATA]: ({ state, data }) => ({ label: { ...state.label, ...data } }),

    [Constants.CLEAR_LABEL_STATE]: ({ state }) => ({
        label: {
            ...state.label,
            pickupForm: {},
            sender: {},
        },
    }),
};
