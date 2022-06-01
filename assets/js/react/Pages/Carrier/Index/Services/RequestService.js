import {curry, identity} from 'ramda';
import {request as _request, url as _url, schema} from 'Services';
import {carriersType} from 'Services/Enums';
import {requestNormalizer} from './DataService';

const getDomain = schema({
    [carriersType.ups]: 'ups',
    [carriersType.fedex]: 'fedex',
});

const request = (path, data, options, useNormalizer = identity) => {
    const sendObj = {
        url: _url.getUrl(path),
        data: useNormalizer(data),
        ...options,
    };

    return _request.sendRequest(sendObj);
};

export const getCarriers = (url) => async () => {
    const [res] = await request(url, {}, { type: 'GET' }, requestNormalizer);

    return requestNormalizer(res);
};

export const save = curry((requestUrl, url, data) => {
    const domain = getDomain(data.type);
    return request(
        `${requestUrl}/${domain}/${url}`,
        data,
        { type: 'POST' },
        requestNormalizer
    );
});

export const deleteItem = curry((requestUrl, url, data) => {
    const domain = getDomain(data.type);
    return request(
        `${requestUrl}/${domain}/${url}`,
        data,
        { type: 'DELETE' },
    );
});

