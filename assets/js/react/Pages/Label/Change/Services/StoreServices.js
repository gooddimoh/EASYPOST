import { getActionStore as _getActionStore, getStoreItem as _getStoreItem } from 'Services';
import Actions from '../Actions';

export const getStoreItem = _getStoreItem('pageState');

export const getActionStore = _getActionStore(Actions);
