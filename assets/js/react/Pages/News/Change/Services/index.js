import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from './StoreServices';
import { requestOnSubmit } from './RequestService';
import { validOnSubmit } from './ValidateService';

export default serviceProps('news', 'news-change', {
    getActionStore,
    getStoreItem,
    requestOnSubmit,
    validOnSubmit
});
