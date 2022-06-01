import _configureStore from 'App/Store';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {

    return _configureStore(props, initState, reducer);
}
