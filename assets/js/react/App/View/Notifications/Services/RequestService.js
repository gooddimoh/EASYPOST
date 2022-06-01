import { request, url } from 'Services';

export const startItem = (link) => {
    const sendObj = {
        url: url.getUrl(link),
        data: {},
        type: 'POST',
    };

    return request.sendRequest(sendObj);
};
