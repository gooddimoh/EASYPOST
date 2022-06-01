import { serviceProps } from "Services";
import { getActionStore, getStoreItem } from './StoreService';
import { deleteItem, requestTable, startItem } from './RequestService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

const pref = 'company';
const url = 'companies';

export default serviceProps(url, pref, {
    deleteItem,
    startItem,
    getViewItem: getViewItem(url),
    getFilter,
    modifierValues,
    requestTable: requestTable(url),
    getTableLabel,
    getStoreItem,
    getActionStore,
});
