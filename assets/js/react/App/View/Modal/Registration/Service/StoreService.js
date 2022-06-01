import { getActionStore as _getActionStore, getStoreItem as _getStoreItem, pathToValue } from 'Services';
import Actions from 'App/Actions/Modal/Registration';

export const getStoreItem = (state, k, d) => {
    const getPath = pathToValue('registration');
    return _getStoreItem('modalState')(state, getPath(k), d);
};

export const getActionStore = _getActionStore(Actions);
