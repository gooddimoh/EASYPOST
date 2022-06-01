import { serviceProps } from "Services";
import { getActionStore, getStoreItem } from './StoreService';

const pref = 'api-integration';
const url = 'doc';

export default serviceProps(url, pref, {
    getStoreItem,
    getActionStore,
});
