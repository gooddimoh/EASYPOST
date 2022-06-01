import { serviceProps } from 'Services';
import main from '../../index';
import { requestTable } from '../../RequestService';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

const url = 'labels';

export default serviceProps(url, main.pref, {
    ...main,
    getFilter,
    getTableLabel,
    modifierValues,
    getViewItem: getViewItem(url),
    requestTable: requestTable(url),
});
