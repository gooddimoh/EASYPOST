import { serviceProps } from 'Services';
import { getStoreItem, getActionStore } from './StoreService';
import { deleteItem, requestTable, startItem} from './RequestService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { modifierValues, getViewItem } from './TableBodyService';

const url = 'transactions';

export default serviceProps(url, 'transaction', {
    deleteItem,
    startItem,
    getViewItem,
    getFilter,
    modifierValues,
    requestTable: requestTable(url),
    getTableLabel,
    getStoreItem,
    getActionStore,
});
