import { serviceProps } from 'Services';
import main from '../../index';
import { getFilter, getTableLabel } from './TableHeaderService';
import { getViewItem, modifierValues } from './TableBodyService';
import { requestPackagesTable } from './RequestService';

const url = 'packages';

export default serviceProps(url, 'packages', {
    ...main,
    isSortEnabled: () => false,
    getFilter,
    getTableLabel,
    getViewItem,
    requestTable: requestPackagesTable(url),
    requestLinkPackage: main.requestOnSubmit('/companies/link-package', 'POST'),
    modifierValues,
});
