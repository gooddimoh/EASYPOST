import { serviceProps } from "Services";
import { requestOnSubmitForm } from "./RequestServices";
import { getActionStore, getStoreItem } from "./StoreServices";

const pref = 'auth';
const url = 'login';

export default serviceProps(url, pref, {
    requestOnSubmitForm: requestOnSubmitForm(url),
    getStoreItem,
    getActionStore
});
