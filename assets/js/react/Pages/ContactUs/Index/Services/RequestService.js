import {request as _request, url as _url} from 'Services';

const request = (path, data) => {
    const sendObj = {
        url: _url.getUrl(path),
        data,
        type: 'POST',
    };

    return _request.sendRequest(sendObj);
};

export const requestOnSubmit = (requestUrl) => async (data) => {
    const [res] = await request(`${requestUrl}/send-email`, data);
    return res;
};