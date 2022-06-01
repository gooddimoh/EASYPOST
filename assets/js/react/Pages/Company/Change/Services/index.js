import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from './StoreServices';
import { requestOnSubmit } from './RequestService';
import { validOnSubmit } from './ValidateService';

export default serviceProps('companies', 'company-change', {
    getActionStore,
    getStoreItem,
    requestOnSubmit,
    validOnSubmit
});
