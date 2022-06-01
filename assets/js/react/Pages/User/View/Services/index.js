import { serviceProps } from 'Services';
import { getStoreItem, getActionStore } from './StoreService';
import { requestOnSubmit, requestTable, deleteItem } from './RequestService';

const pref = 'user-view';
const url = 'users';

export const columnsForPackages = ['title', 'price', 'usps', 'ups', 'fedex', 'useFedex', 'useUps', 'pickup'];

export default serviceProps(url, pref, {
    deleteItem,
    requestTable: requestTable(url),
    getStoreItem,
    getActionStore,
    requestOnSubmit,
});
