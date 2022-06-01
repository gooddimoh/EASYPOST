import { serviceProps } from 'Services';
import { getStoreItem, getActionStore } from './StoreService';
import { requestOnSubmit } from './RequestService';
import { validOnSubmit } from './ValidateService';

const pref = 'user-change';
const url = 'users';

export default serviceProps(url, pref, {
    getActionStore,
    getStoreItem,
    requestOnSubmit,
    validOnSubmit,
});
