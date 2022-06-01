import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from './StoreService';
import { request, deleteItem, requestTable } from './RequestService';
import { check20dayTerms } from './DateService';

const pref = 'label';
const url = 'labels';

export default serviceProps(url, pref, {
    requestLabelInfo: (id) => request(`${url}/${id}`, {}, { type: 'GET' }),
    deleteItem,
    requestTable,
    getStoreItem,
    getActionStore,
    check20dayTerms,
});
