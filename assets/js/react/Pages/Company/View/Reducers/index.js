import { schemaReducer } from 'Services';
import { initState as tableState, reducer as tableReducer } from './TableReducer';
import { initState as pageState, reducer as pageReducer } from './PageReducer';

export const initState = {
    request: 0,
    forceUpdate: 0,
    ...tableState,
    ...pageState,
};

const reducers = {
    ...tableReducer,
    ...pageReducer,
};

export default schemaReducer(initState, reducers);

