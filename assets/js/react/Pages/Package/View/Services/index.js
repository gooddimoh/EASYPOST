import { serviceProps } from "Services";
import { getActionStore, getStoreItem } from './StoreService';
import { deleteItem, requestTable } from './RequestService';


export default serviceProps('companies', 'company', {
    deleteItem,
    requestTable,
    getStoreItem,
    getActionStore,
});
