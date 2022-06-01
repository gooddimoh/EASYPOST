import { curry, identity } from 'ramda';
import { request as _request, url } from 'Services';

export const request = (path, data, options) => {
    const sendObj = {
        url: url.getUrl(path),
        data,
        ...options,
    };

    return _request.sendRequest(sendObj);
};

export const normalizeOnSubmit = curry(async (normalizer, requestUrl, data) => {
    const [res] = await request(requestUrl, normalizer(data), { type: 'POST' });
    return res;
});

export const requestOnSubmit = normalizeOnSubmit(identity);

export const getResponse =
    (requestUrl) =>
    async (data = {}) => {
        const [res] = await request(requestUrl, data, { type: 'GET' });
        return res;
    };

export const requestAddressBooksById = (requestUrl) => async (data) => {
    const [response] = await request(requestUrl, data, { type: 'GET' });
    const { items } = response;
    const [result] = items;
    return result;
};
