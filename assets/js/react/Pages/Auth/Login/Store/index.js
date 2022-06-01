import _configureStore from 'App/Store';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {
    const { csrf_token } = props;

    const state = {
        ...initState,
        csrf_token
    };

    return _configureStore(props, state, reducer);
}
