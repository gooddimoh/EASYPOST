import { concat } from 'ramda';
import Constants from '../Constants';

export const initState = {
    items: [],
    pagination: {},
    sort: {},
    columns: [],
    errors: {},
};

export const reducer = {
    [Constants.TABLE_SORT]: ({ data }) => data,
    [Constants.FETCH_ITEMS_REQUESTED]: ({ data }) => data,
    [Constants.FETCH_ITEMS_SUCCEEDED]: ({ data }) => data,
    [Constants.FETCH_ITEMS_FAILED]: ({ data }) => ({ items: [], errors: data }),
    [Constants.FORCE_FETCH]: ({ state }) => ({ request: state.request + 1 }),
    [Constants.NEXT_PAGE]: ({ state, data }) => ({
        items: concat(state.items, data.items),
        pagination: data.pagination,
    }),
};
