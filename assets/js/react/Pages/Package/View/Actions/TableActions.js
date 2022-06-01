import { compose } from 'ramda';
import { changeFilter } from 'Services';
import Constants from '../Constants';

const requestFailed = (data) => ({ type: Constants.FETCH_ITEMS_FAILED, data });

const requestSucceeded = (data) => ({ type: Constants.FETCH_ITEMS_SUCCEEDED, data });

const requestNextPageSucceeded = (data) => ({ type: Constants.NEXT_PAGE, data });

export const fetchItems =
    (dispatch, { service }) =>
    (data) => {
        const { sort } = data;
        const { requestTable } = service;
        requestTable(data).then(
            (res) => {
                dispatch(requestSucceeded({ ...res, sort: { ...(sort || {}) } }));
            },
            (res) => {
                dispatch(requestFailed(res));
            },
        );
    };

export const onChange = (dispatch) =>
    compose(
        (data) => dispatch({ type: Constants.CHANGE_FILTER, data }),
        changeFilter(['date', 'age', 'language', 'gender', 'status', 'time', 'country'])
    );

export const forceFetch = (dispatch) => () => dispatch({ type: Constants.FORCE_FETCH });

export const fetchPage = (service, dispatch) => (data) => {
    const { requestTable } = service;

    requestTable(data).then(
        (res) => dispatch(requestNextPageSucceeded(res)),
        (res) => dispatch(requestFailed(res)),
    );
};
