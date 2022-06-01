import { serviceProps } from 'Services';
import { getStoreItem, getActionStore } from './StoreService';
import { requestOnSubmit } from './RequestService';

const url = 'about';

export default serviceProps(url, 'about', {
    requestOnSubmit,
    getStoreItem,
    getActionStore,
});
