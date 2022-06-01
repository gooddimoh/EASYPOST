import { serviceProps } from "Services";
import { getActionStore, getStoreItem } from './StoreService';
import { requestOnSubmit } from './RequestService';
import { validOnSubmit } from './ValidateService';

const pref = 'contact';
const url = 'contact';

export default serviceProps(url, pref, {
    getStoreItem,
    getActionStore,
    requestOnSubmit: requestOnSubmit(url),
    validOnSubmit,
});
