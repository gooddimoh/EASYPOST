import _configureStore from 'App/Store';
import reducer, {initState} from '../Reducers';

export default function configureStore(props) {

    const state = {
        ...initState,
    };

    return _configureStore(props, state, reducer);
}
