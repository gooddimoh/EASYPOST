import _configureStore from 'App/Store';
import { generateKeyRender } from 'Services';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {
    const { items, pagination, columns, sort } = generateKeyRender(props);

    const state = {
        ...initState,
        items,
        pagination,
        columns,
        sort,
    };

    return _configureStore(props, state, reducer);
};