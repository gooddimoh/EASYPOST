import { getStoreItem as _getStoreItem, getActionStore as _getActionStore } from 'Services';
import * as Actions from '../Actions';

export const getStoreItem = _getStoreItem('pageState');

export const getActionStore = _getActionStore({
    ...Actions,
});
