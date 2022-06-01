import { serviceProps } from 'Services';
import { requestOnSubmitForm } from './RequestServices';
import { getActionStore, getStoreItem } from './StoreServices';

const pref = 'forgot';
const url = 'auth/request';

export default serviceProps(url, pref, {
    requestOnSubmitForm: requestOnSubmitForm(url),
    getStoreItem,
    getActionStore,
});
