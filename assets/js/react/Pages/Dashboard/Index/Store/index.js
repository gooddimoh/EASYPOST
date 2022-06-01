import _configureStore from 'App/Store';
import { generateKeyRender } from 'Services';
import reducer, { initState } from '../Reducers';


export default function configureStore(props) {

    const { items } = generateKeyRender(props.news);

    const state = {
        ...initState,
        newsItems: [...items]
    };

    return _configureStore(props, state, reducer);
}
