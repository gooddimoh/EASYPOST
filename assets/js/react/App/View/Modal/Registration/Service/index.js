import { compose } from 'ramda';
import { serviceProps } from 'Services';
import { requestOnSubmit } from './RequestService';
import { getStoreItem, getActionStore } from './StoreService';
import { validOnSubmit } from './ValidateService';
import { validateFormData, formData } from './FormService';

const formatStoreItem = (keyName, state, defaultValue = '') => ({
    [keyName]: {
        value: getStoreItem(state, `${keyName}`, defaultValue),
        error: getStoreItem(state, ['formErrors', `${keyName}`], []),
    },
});

export default serviceProps('', 'registration-modal', {
    getStoreItem,
    formatStoreItem,
    getActionStore,
    requestOnSubmit,
    requestRegistration: compose(requestOnSubmit('/users/full-registration'), formData),
    validOnSubmit,
    validateFormData,
});
