import { schemaReducer } from 'Services';
import { initState as pageState, reducer as pageReducer } from './PageReducer';
import { initState as tableState, reducer as tableReducer } from './TableReducer';

const reducers = {
    ...pageReducer,
    ...tableReducer,
};

export const initState = {
    request: 0,
    forceUpdate: 0,
    ...pageState,
    ...tableState,
};

export default schemaReducer(initState, reducers);
