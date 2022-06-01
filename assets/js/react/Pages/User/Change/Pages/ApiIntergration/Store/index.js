import _configureStore from 'App/Store';
import reducer from '../../../Reducers';

export default (props) => {
    const { csrf_token } = props;

    const state = {
        csrf_token
    };

    return _configureStore(props, state, reducer);
};
