import { compose } from 'ramda';
import { serviceProps } from 'Services';
import main from '../index';
import { getStoreItem, getActionStore } from './StoreService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

const serviceKey = 'statistic_label';

export default serviceProps(main.url, main.pref, {
    ...main,
    serviceKey,
    getStoreItem,
    getActionStore,
    getFilter,
    getTableLabel,
    modifierValues,
    getViewItem: getViewItem(`/${main.url}/statistic-label`),
    requestOnSubmit: compose(main.requestOnSubmit(`/${main.url}/statistic-label`), main.formData),
    requestTable: main.requestTable(`/${main.url}/statistic-label`),
});
