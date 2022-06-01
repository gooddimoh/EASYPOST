import _configureStore from 'App/Store';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {
    const { view } = props;

    const state = {
        ...initState,
        view
    };

    return _configureStore(props, state, reducer);
}
