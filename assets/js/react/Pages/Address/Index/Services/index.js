import { serviceProps } from "Services";
import { getActionStore, getStoreItem } from './StoreService';
import { deleteItem, requestTable } from './RequestService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

const url = 'address-books';

export default serviceProps(url, 'address', {
    deleteItem,
    requestTable: requestTable(url),
    getFilter,
    getTableLabel,
    getViewItem,
    modifierValues,
    getStoreItem,
    getActionStore
});
