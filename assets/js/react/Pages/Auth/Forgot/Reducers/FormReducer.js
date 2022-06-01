import Constants from '../Constants';

export const initState = {
    error: '',
    status: '',
};

export const reducer = {
    [Constants.SUBMIT_FROM_REQUEST]: () => ({ status: 'request' }),
    [Constants.SUBMIT_FROM_SUCCEEDED]: ({ data }) => ({ status: 'success', email: data.email }),
    [Constants.SUBMIT_FROM_FAILURE]: ({ data }) => ({ status: 'failure', error: data }),
};
