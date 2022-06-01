import { serviceProps } from 'Services';
import main from '../../index';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

export default serviceProps(main.url, main.pref, {
    ...main,
    getViewItem,
    getFilter,
    modifierValues,
    requestTable: main.requestTable(main.url),
    getTableLabel,
});
