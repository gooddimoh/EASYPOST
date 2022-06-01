import { getActionStore as _getActionStore, getStoreItem as _getStoreItem, pathToValue } from 'Services';
import Actions from "App/Actions/Modal/Label";


export const getStoreItem = (state, k, d) => {
    const getPath = pathToValue('label');
    return _getStoreItem('modalState')(state, getPath(k), d);
};

export const getActionStore = _getActionStore(Actions);
