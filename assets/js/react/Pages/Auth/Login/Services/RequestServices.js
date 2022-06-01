import { request as _request } from 'Services';

const request = (data, path) => {
    const sendObj = {
        url: `/${ path }`,
        data,
        type: 'POST',
    };

    return _request.sendRequest(sendObj);
};

export const requestOnSubmitForm = (url) => async (data) => {
    try {
        const [res] = await request(data, url);
        return res;
    } catch (error) {
        return error;
    }
};
