import Constants from '../Constants';

export const initState = {
    error:  (Date.now() - window.localStorage.banTime) < 16 * 60 * 1000  ? "Brute" : '',
    lastAction: '',
    sessions: [],
};

export const reducer = {
    [Constants.SUBMIT_FROM_FAILURE]: ({data}) => ({lastAction: Constants.SUBMIT_FROM_FAILURE, error: data.error})
};
