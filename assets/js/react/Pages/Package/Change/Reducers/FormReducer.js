import { omit, isEmpty } from 'ramda';
import { changeForm } from 'Services/Store';
import Constants from '../Constants';

export const initState = {
    id: '',
    name: '',
    price_label: '',
    price_month: '0',
    price_additional: '0',
    available_company: '',
    api: [],
    carriersOptions: [],
    carriers: [],
    useCarriers: [],
    pickup: [],

    formValidate: false,
    formLoading: false,
    formErrors: {},
};

export const reducer = {
    [Constants.CHANGE_FORM]: changeForm,
    [Constants.CHANGE_FORM_USE_CARRIERS]: ({ state, data }) => ({
        carriers: isEmpty(data.value) ? [] : state.carriers.filter((i) => data.value.includes(i)),
        useCarriers: data.value,
    }),
    [Constants.VALIDATE_FORM]: ({ data }) => data,
    [Constants.FORM_REQUESTED]: () => ({ formLoading: true }),
    [Constants.FORM_SUCCEEDED]: () => ({ formLoading: false }),
    [Constants.FORM_FAILED]: ({ data }) => ({ formErrors: data, formLoading: false }),
    [Constants.FORM_RESET]: () => omit(['carriersOptions'], initState),
};
