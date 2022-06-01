import { curry } from 'ramda';
import { compose, createStore } from 'redux';
import { combineReducers, combineStore } from 'App/Services';

export default curry((props, pageStore, reducer) => {
    const composeEnhancers = (process.env.NODE_ENV === 'development' && typeof window !== "undefined" && window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__) || compose;

    const initState = combineStore(props, pageStore);
    const reducers = combineReducers(reducer);

    return createStore(reducers, initState, composeEnhancers());
});
