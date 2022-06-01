import { serviceProps } from "Services";
import { getActionStore, getStoreItem } from './StoreService';
import { deleteItem, save, getCarriers } from './RequestService';
import { validOnSubmit } from './ValidateService';

const pref = 'carrier';
const url = 'carriers';

export default serviceProps(url, pref, {
    deleteItem: deleteItem(url),
    getStoreItem,
    getActionStore,
    save: save(url),
    getCarriers: getCarriers(url),
    validOnSubmit,
});
