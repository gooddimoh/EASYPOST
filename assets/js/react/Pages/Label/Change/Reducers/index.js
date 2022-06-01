import { schemaReducer } from 'Services';
import { initState as formState, reducer as formReducer } from './FormReducer';

export const initState = {
    ...formState,
};

const reducers = {
    ...formReducer,
};

export default schemaReducer(initState, reducers);
