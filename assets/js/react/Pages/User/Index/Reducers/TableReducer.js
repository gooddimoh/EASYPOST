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
    [Constants.FORCE_FETCH]: ({ state }) => ({ request: state.request + 1 }),
    [Constants.FETCH_ITEMS_REQUESTED]: ({ data }) => ({ ...data, loading: true }),
    [Constants.FETCH_ITEMS_SUCCEEDED]: ({ data }) => ({ ...data, loading: false }),
    [Constants.FETCH_ITEMS_FAILED]: ({ data }) => ({ items: [], errors: data, loading: false }),
};
