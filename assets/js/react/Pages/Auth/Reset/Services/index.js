import { serviceProps } from 'Services';
import { requestOnSubmitForm } from './RequestServices';
import { getActionStore } from './StoreServices';

const url = 'auth/reset';

export default serviceProps(url, 'auth', {
    requestOnSubmitForm: requestOnSubmitForm(url),
    getActionStore,
});
