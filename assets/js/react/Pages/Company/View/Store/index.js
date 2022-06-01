import _configureStore from 'App/Store';
import { generateKeyRender } from 'Services';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {

    const { view, pagination, items, columns } = generateKeyRender(props);

    const state = {
        ...initState,
        view,
        pagination,
        items,
        columns,
        filter: {
            companyId:view.id
        },
    };

    return _configureStore(props, state, reducer);
}
