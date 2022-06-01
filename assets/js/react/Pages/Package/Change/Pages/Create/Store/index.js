import _configureStore from 'App/Store';
import reducer, { initState } from '../../../Reducers';
import { normalizeCarriers } from '../../../Services/DataService';

export default (props) => {
    const { carriers } = props;

    const state = {
        ...initState,
        carriersOptions: normalizeCarriers(carriers),
    };

    return _configureStore(props, state, reducer);
};
