import { getActionStore as _getActionStore } from 'Services';
import { PageActions } from '../Actions';

export const getActionStore = _getActionStore({
    ...PageActions,
});
