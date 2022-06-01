import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from "./StoreServices";
import { requestOnSubmit } from './RequestService';
import { validOnSubmit } from './ValidateService';
import { dataRequestNormalizer } from './DataService';

export default serviceProps('transactions', 'transaction-change', {
    getActionStore,
    getStoreItem,
    requestOnSubmit,
    validOnSubmit,
    dataRequestNormalizer,
});
