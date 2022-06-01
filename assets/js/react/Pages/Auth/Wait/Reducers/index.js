import { schemaReducer } from 'Services';
import { initState as _initState, reducer } from './WaitReducer';

export const initState = _initState;

export default schemaReducer(initState, reducer);


