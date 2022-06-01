import { serviceProps } from 'Services';
import { getStoreItem, getActionStore } from './StoreService';
import { requestTable, deleteItem } from './RequestService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { modifierValues, getViewItem } from './TableBodyService';

const pref = 'user';
const url = 'users';

export default serviceProps(url, pref, {
    deleteItem,
    getViewItem: getViewItem(url),
    getFilter,
    modifierValues,
    requestTable: requestTable(url),
    getTableLabel,
    getStoreItem,
    getActionStore,
});
