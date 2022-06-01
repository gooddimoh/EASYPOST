import { serviceProps } from 'Services';
import { getStoreItem, getModalActionStore } from './StoreService';

export default serviceProps('', 'top-panel', {
    getStoreItem,
    getModalActionStore,
});
