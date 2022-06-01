import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from './StoreService';
import { requestTable } from './RequestService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

const pref = 'package';
const url = 'packages';

export default serviceProps(url, pref, {
    getViewItem: getViewItem(url),
    getFilter,
    modifierValues,
    requestTable: requestTable(url),
    getTableLabel,
    getStoreItem,
    getActionStore,
});
