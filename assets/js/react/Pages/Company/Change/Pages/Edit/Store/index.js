import _configureStore from 'App/Store';
import reducer, { initState } from '../../../Reducers';
import {responseNormalizer} from '../Services/NormalizeDataService';

export default (props) => {
    const { user, ...other } = props;

    const _other = responseNormalizer(other);

    const state = {
        ...initState,
        ..._other,
    };

    return _configureStore(props, state, reducer);
};
