import { getStoreItem as _getStoreItem, getActionStore as _getActionStore } from 'Services';
import Actions from '../Actions';

export const getStoreItem = _getStoreItem('pageState');

export const getActionStore = _getActionStore(Actions);
