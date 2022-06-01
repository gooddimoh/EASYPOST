import { __ } from 'ramda';
import _configureStore from 'App/Store';
import reducer, { initState } from '../Reducers';

export default _configureStore(__, initState, reducer);
