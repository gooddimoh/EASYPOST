import { request as _request, url as _url } from 'Services';

const request = (url, data) => _request.sendRequest({
    url: _url.getUrl(url),
    data,
    type: 'POST',
});

export const requestOnSubmitForm = url => token => data =>
    new Promise((resolve, reject) => {
        request(`${ url }/${ token }`, data).then(
            res => resolve(res),
            res => reject(res)
        );
    });
