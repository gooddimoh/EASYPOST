import { schemaReducer } from 'Services';
import { initState as pageState, reducer as pageReducer } from './PageReducer';

const reducers = {
    pageReducer,
};

export const initState = {
    ...pageState,
};

export default schemaReducer(initState, reducers);
