import { url } from 'Services';
import Constants from '../Constants';

export const submitFormAction = (dispatch, { service }) => (data) => {
    dispatch({ type: Constants.SUBMIT_FROM_REQUEST });

    const { requestOnSubmitForm } = service;

    return requestOnSubmitForm(data).then(
        (res) => {
            if (res.redirect) {
                url.redirect(res.redirect);
                return;
            }

            if (res.error === 'Auth request limit') {
                window.localStorage.setItem('banTime', Date.now());
                url.redirect('/auth/wait');
            }

            dispatch({ type: Constants.SUBMIT_FROM_FAILURE, data: res });
        },
        (res) => dispatch({ type: Constants.SUBMIT_FROM_FAILURE, data: res })
    );
};
