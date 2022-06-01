import { request as _request, url } from 'Services';

const request = (path, data, options) => {
    const sendObj = {
        url: url.getUrl(path),
        data,
        ...options,
    };

    return _request.sendRequest(sendObj);
};

export const requestOnSubmit =
    (requestUrl, type = 'POST') =>
    async (data) => {
        const [res] = await request(requestUrl, data, { type });
        return res;
    };
