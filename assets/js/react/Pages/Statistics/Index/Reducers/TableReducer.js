import { concat } from 'ramda';
import {replaceFilter} from 'Services/Store';
import Constants from '../Constants';

export const initState = {};

export const reducer = {
    [Constants.CHANGE_FILTER]: replaceFilter,
    [Constants.FORCE_FETCH]: ({ state }) => ({ request: state.forceUpdate + 1 }),
    [Constants.TABLE_SORT]: ({ data }) => data,
    [Constants.FETCH_ITEMS_REQUESTED]: ({ data }) => ({ ...data, loading: true }),
    [Constants.FETCH_ITEMS_SUCCEEDED]: ({ data }) => ({ ...data, loading: false }),
    [Constants.FETCH_ITEMS_FAILED]: ({ data }) => ({ errors: data, loading: false }),
    [Constants.FORCE_FETCH]: ({ state }) => ({ forceUpdate: state.forceUpdate + 1 }),
    [Constants.NEXT_PAGE]: ({ state, data }) => ({
        items: concat(state.items, data.items),
        pagination: data.pagination,
        loading: false,
    }),
};
