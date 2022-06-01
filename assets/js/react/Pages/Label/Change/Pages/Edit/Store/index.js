import { toString, equals } from 'ramda';
import _configureStore from 'App/Store';
import reducer, { initState } from '../../../Reducers';

export default (props) => {
    const { user, ...other } = props;
    const { price, packages, options } = other;
    const pickup = equals(options.need_pickup, '10') ? ['pickup'] : [];

    const state = {
        ...initState,
        ...other,
        price: toString(price),
        packages: packages.map((item) => ({ ...item, price: toString(item.price) })),
        pickup,
    };

    return _configureStore(props, state, reducer);
};
