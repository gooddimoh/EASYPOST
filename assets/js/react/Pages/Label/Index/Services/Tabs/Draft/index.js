import { serviceProps } from 'Services';
import main from '../../index';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';

const url = `${main.url}/draft`;

export default serviceProps(url, main.pref, {
    ...main,
    getViewItem,
    getFilter,
    modifierValues,
    requestTable: main.requestTable(url),
    getTableLabel,
});
