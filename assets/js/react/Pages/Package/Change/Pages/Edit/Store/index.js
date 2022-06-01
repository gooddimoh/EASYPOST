import _configureStore from 'App/Store';
import reducer, { initState } from '../../../Reducers';
import { dataResponseNormalizer, normalizeCarriers } from '../../../Services/DataService';

export default (props) => {
    const { user, carriers, ...other } = props;

    const state = {
        ...initState,
        carriersOptions: normalizeCarriers(carriers),
        ...dataResponseNormalizer(other),
    };

    return _configureStore(props, state, reducer);
};
