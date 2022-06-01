import { serviceProps } from 'Services';
import { getActionStore, getStoreItem } from "./StoreServices";
import { requestOnSubmit } from './RequestService';
import { dataRequestNormalizer, normalizeCarriers } from './DataService';
import { validOnSubmit } from './ValidateService';

const pref = 'package-change';
const url = 'packages';

export default serviceProps(url, pref, {
    getActionStore,
    getStoreItem,
    requestOnSubmit,
    dataRequestNormalizer,
    normalizeCarriers,
    validOnSubmit,
});
