import { request as _request, url } from 'Services';

const request = (path, data, options) => {
    const sendObj = {
        url: url.getUrl(path),
        data,
        ...options,
    };

    return _request.sendRequest(sendObj);
};

export const getBalance = async () => {
    try {
        const [res] = await request('/companies/balance', {}, { type: 'GET' });
        return res;
    } catch (error) {
        return error;
    }
};
