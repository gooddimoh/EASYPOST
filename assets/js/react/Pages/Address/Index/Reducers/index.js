import { schemaReducer } from 'Services';
import { initState as tableState, reducer as tableReducer } from './TableReducer';
import { initState as filterState, reducer as filterReducer } from './FilterReducer';
import { initState as pageState, reducer as pageReducer } from './PageReducer';

const reducers = {
    ...tableReducer,
    ...filterReducer,
    ...pageReducer
};

export const initState = {
    request: 0,
    forceUpdate: 0,
    ...tableState,
    ...filterState,
    ...pageState,
};

export default schemaReducer(initState, reducers);
