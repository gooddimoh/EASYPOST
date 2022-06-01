import { schemaReducer } from 'Services';
import { initState as pageState, reducer as pageReducer } from './PageReducer';

export const initState = {
    ...pageState,
};

const reducers = {
    ...pageReducer,
};

export default schemaReducer(initState, reducers);
