import _configureStore from 'App/Store';
import { generateKeyRender, url as _url } from 'Services';
import reducer, { initState } from '../Reducers';
import { columnsForPackages } from '../Services';

export default function configureStore(props) {
    const { view, pagination, items, columns } = generateKeyRender(props);

    const isPackage = _url.getParams() === 'tab=package';
    const packageTabOptions = {
        activeTab: 4,
        pagination: {},
        columns: columnsForPackages,
    };

    const _state = {
        ...initState,
        view,
        activeTab: 0,
        pagination,
        items,
        columns,
        filter: {
            userId: view.id,
        },
    };

    const state = isPackage ? { ..._state, ...packageTabOptions } : _state;

    return _configureStore(props, state, reducer);
}
