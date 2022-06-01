import { url } from 'Services';
import Constants from '../Constants';

export const submitFormAction = (dispatch, { service }) => (data) => {
    dispatch({ type: Constants.SUBMIT_FROM_REQUEST });

    const { requestOnSubmitForm } = service;

    return requestOnSubmitForm(data).then(
        (res) => {
            dispatch({ type: Constants.SUBMIT_FROM_SUCCEEDED, data: res });
            url.redirect('/login');
        },
        (res) => {
            dispatch({ type: Constants.SUBMIT_FROM_FAILURE, data: res });
        },
    );
};
