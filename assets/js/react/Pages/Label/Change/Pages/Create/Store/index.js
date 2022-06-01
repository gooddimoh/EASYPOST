import _configureStore from 'App/Store';
import reducer, { initState } from '../../../Reducers';

export default (props) => {
    const { user, ...other } = props;

    const state = {
        ...initState,
        ...other,
    };

    return _configureStore(props, state, reducer);
};
