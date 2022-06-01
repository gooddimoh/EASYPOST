import { schemaReducer } from 'Services';
import { initState as formState, reducer as formReducer } from "./FormReducer";

const reducers = {
    ...formReducer
};

export const initState = {
    request: 0,
    ...formState
};

export default schemaReducer(initState, reducers);
