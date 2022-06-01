import { nanoid } from 'nanoid';
import { sum, multiply, toString, compose } from 'ramda';
import { serviceProps } from 'Services';
import { requestAddressBooksById, normalizeOnSubmit } from 'App/View/Modal/Label/Services/RequestService';
import { formDataLabelRates, formDataSave, formDataPickupRates } from 'App/View/Modal/Label/Services/FormService';
import { getActionStore, getStoreItem } from './StoreServices';
import { validOnSubmit } from './ValidateService';
import { requestOnSubmit } from './RequestService';

const newItemTemplate = () => ({
    _id: nanoid(10),
    description: '',
    quantity: '',
    weight: '',
    price: '',
});

const calcWholeOption = (data) => {
    const initialRes = { weight: 0, price: 0 };

    return data.reduce(
        (acc, cur) => ({
            weight: toString(sum([acc.weight, multiply(cur.weight, cur.quantity)])),
            price: toString(sum([acc.price, multiply(cur.price, cur.quantity)])),
        }),
        initialRes,
    );
};

const url = 'labels';

export default serviceProps(url, 'label-change', {
    getActionStore,
    getStoreItem,
    requestRates: normalizeOnSubmit(formDataLabelRates, `${url}/get-shipment-rates`),
    requestOnSubmit: normalizeOnSubmit(formDataSave, `${url}/create`),
    requestOnSubmitPickup: (labelId, data) =>
        normalizeOnSubmit(formDataPickupRates, `${url}/${labelId}/get-pickup-rates`, data),
    newItemTemplate,
    calcWholeOption,
    requestAddressBooksById: requestAddressBooksById('address-books'),
    validOnSubmit,
    createDraft: compose(requestOnSubmit(`${url}/create-draft`), formDataLabelRates),
    editDraft: (id, data) => requestOnSubmit(`${url}/${id}/edit`)(formDataLabelRates(data)),
    requestPackages: requestOnSubmit('/packages', 'GET'),
});
