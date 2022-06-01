import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from './StoreService';
import { tableLabel, getLabel, getTableRow } from './TableService';

export default serviceProps('labels', 'label', {
    getStoreItem,
    getActionStore,
    tableLabel,
    getLabel,
    getTableRow,
});
