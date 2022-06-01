import _configureStore from 'App/Store';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {
    const { token, error } = props;

    const state = {
        ...initState,
        token,
        error
    };

    return _configureStore(props, state, reducer);
}
