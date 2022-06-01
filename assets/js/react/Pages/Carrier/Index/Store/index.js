import _configureStore from 'App/Store';
import {generateKeyRender} from 'Services';
import reducer, {initState} from '../Reducers';

export default function configureStore(props) {
    const {items, pagination, columns, sort} = generateKeyRender(props);

    const _items = items.map(item => ({
        ...item,
        credentials: JSON.parse(item.credentials),
    }));

    const state = {
        ...initState,
        items: _items,
        pagination,
        columns,
        sort,
    };

    return _configureStore(props, state, reducer);
}
