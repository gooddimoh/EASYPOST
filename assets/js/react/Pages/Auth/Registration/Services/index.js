import { serviceProps } from 'Services';
import { customRequest } from './RequestServices';
import { getActionStore, getStoreItem } from './StoreServices';
import { validOnSubmit } from './ValidateService';
import { userNormalizer } from './DataService';

const pref = 'auth';
const url = 'user';

export default serviceProps(url, pref, {
    userRequest: customRequest('/registration', userNormalizer),
    getStoreItem,
    getActionStore,
    validOnSubmit,
});
