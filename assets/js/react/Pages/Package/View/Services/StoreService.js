import { getStoreItem as _getStoreItem, getActionStore as _getActionStore } from 'Services';
import { TableActions, PageActions } from '../Actions';

export const getStoreItem = _getStoreItem('pageState');

export const getActionStore = _getActionStore({
    ...TableActions,
    ...PageActions,
});
