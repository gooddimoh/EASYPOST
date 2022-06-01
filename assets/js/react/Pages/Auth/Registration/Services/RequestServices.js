import { request as _request, url as _url } from 'Services';

const request = (data, path) => {
    const sendObj = {
        url: _url.getUrl(path, {} , '/auth'),
        data,
        type: 'POST',
    };

    return _request.sendRequest(sendObj);
};

export const customRequest = (url, normalizer) => async (data) => {
    try {
        const [res] = await request(normalizer(data), url);
        return res;
    } catch (error) {
        return error;
    }
};