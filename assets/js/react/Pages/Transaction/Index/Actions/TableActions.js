import {compose} from 'ramda';
import {changeFilter} from 'Services';
import Constants from '../Constants';

const requestFailed = (data) => ({ type: Constants.FETCH_ITEMS_FAILED, data });

const requestSucceeded = (data) => ({ type: Constants.FETCH_ITEMS_SUCCEEDED, data });

const requestNextPageSucceeded = (data) => ({ type: Constants.NEXT_PAGE, data });

export const fetchItems = (dispatch, { service }) => async (data) => {

    const { sort } = data;
    const { requestTable } = service;

    try {
        const res = await requestTable(data);
        dispatch(requestSucceeded({ ...res, sort: { ...(sort || {}) } }));
    } catch (e) {
        dispatch(requestFailed(e));
    }
};

export const onChange = (dispatch) => compose(
    (data) => dispatch({ type: Constants.CHANGE_FILTER, data }),
    changeFilter(['date', 'name', 'status', 'type'])
);

export const forceFetch = (dispatch) => () => dispatch({ type: Constants.FORCE_FETCH });

export const fetchPage = (service, dispatch) => (data) => {
    const { requestTable } = service;

    requestTable(data).then(
        (res) => {
            dispatch(requestNextPageSucceeded(res));
        },
        (res) => {
            dispatch(requestFailed(res));
        },
    );
};
