import { partialRight } from 'ramda';
import { generateKeyRender, request as _request, url as _url } from 'Services';

const request = (path, data, options) => {
    const sendObj = {
        url: _url.getUrl(path),
        data,
        ...options
    };

    return _request.sendRequest(sendObj);
};

export const requestTable = (url) => async (data) => {
    const [res] = await request(url, data, { type: 'GET' });
    return generateKeyRender(res);
};

export const deleteItem = partialRight(request, [{}, { type: 'DELETE' }]);
