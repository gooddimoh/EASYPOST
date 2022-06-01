import { serviceProps, schemaCall } from 'Services';
import { modalViewsEnum } from 'Services/Enums';
import { getStoreItem, getActionStore } from './StoreServices';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';
import { validOnSubmit } from './ValidateService';
import { requestOnSubmit, normalizeOnSubmit, requestAddressBooksById, getResponse } from './RequestService';
import { formDataLabelRates, formDataPickupRates, formDataSave } from './FormService';

const url = 'labels';

export const getNextScreen = schemaCall({
    [modalViewsEnum.labelRates]: (opt) => (opt.includes('pickup') ? modalViewsEnum.pickupForm : modalViewsEnum.success),
    [modalViewsEnum.pickupForm]: () => modalViewsEnum.pickupRates,
    [modalViewsEnum.pickupRates]: () => modalViewsEnum.success,
});

const service = serviceProps(url, 'label-modal', {
    getStoreItem,
    isSortEnabled: () => false,
    getFilter,
    getTableLabel,
    getViewItem,
    modifierValues,
    validOnSubmit,
    getActionStore,
    requestRates: normalizeOnSubmit(formDataLabelRates, `${url}/get-shipment-rates`),
    requestLabelInfo: (id) => getResponse(`${url}/${id}`),
    requestOnSubmit: normalizeOnSubmit(formDataSave, `${url}/create`),
    requestOnSubmitPickup: (labelId, data) =>
        normalizeOnSubmit(formDataPickupRates, `${url}/${labelId}/get-pickup-rates`, data),
    requestPickup: (labelId, data) => requestOnSubmit(`${url}/${labelId}/buy-pickup`, data),
    requestAddressBooksById,
});

export default service;
