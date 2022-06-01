import { schemaReducer } from 'Services';
import { initState as tableState, reducer as tableReducer } from "./TableReducer";
import { initState as filterState, reducer as filterReducer } from "./FilterReducer";

const reducers = {
    ...tableReducer,
    ...filterReducer
};

export const initState = {
    request: 0,
    ...tableState,
    ...filterState,
};

export default schemaReducer(initState, reducers);
