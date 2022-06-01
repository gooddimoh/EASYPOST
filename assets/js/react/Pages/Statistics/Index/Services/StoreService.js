import { getStoreItem as _getStoreItem, getActionStore as _getActionStore } from 'Services';
import { PageActions } from '../Actions';

export const getStoreItem = _getStoreItem('pageState');

export const getActionStore = _getActionStore(PageActions);
