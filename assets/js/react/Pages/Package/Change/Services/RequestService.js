import { request, url } from 'Services';
import { dataRequestNormalizer } from './DataService';

const save = (data, requestUrl) => {
    const sendObj = {
        url: url.getUrl(requestUrl),
        data: dataRequestNormalizer(data),
        type: 'POST',
        processData: false,
        contentType: false,
    };

    return request.sendRequest(sendObj);
};

export const requestOnSubmit = (requestUrl) => async (data) => {
    try {
        const [res] = await save(data, requestUrl);
        return res;
    } catch (error) {
        return error;
    }
};
