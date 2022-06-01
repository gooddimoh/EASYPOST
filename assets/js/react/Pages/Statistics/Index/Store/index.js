import _configureStore from 'App/Store';
import reducer, { initState } from '../Reducers';

export default function configureStore(props) {
    const { statistic } = props;

    const state = {
        ...initState,
        ...statistic,
    };

    return _configureStore(props, state, reducer);
}
