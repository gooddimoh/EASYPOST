import { schemaReducer } from 'Services';
import { initState as _initState, reducer } from './FormReducer';

export const initState = _initState;

export default schemaReducer(initState, reducer);

