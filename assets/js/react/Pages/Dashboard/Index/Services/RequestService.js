import { request as _request, url as _url } from 'Services';

export const request = (path, data, options) => {
    const sendObj = {
        url: _url.getUrl(path),
        data,
        ...options,
    };

    return _request.sendRequest(sendObj);
};

export const requestOnSubmit =
    (url, type = 'GET') =>
    async (data) => {
        const [res] = await request(url, data, { type });
        return res;
    };
