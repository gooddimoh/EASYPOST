import { getActionStore as _getActionStore, getStoreItem as _getStoreItem } from 'Services';
import { FormActions } from '../Actions';

export const getStoreItem = _getStoreItem('pageState');

export const getActionStore = _getActionStore({
    ...FormActions
});
