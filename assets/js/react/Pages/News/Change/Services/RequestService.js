import { request, url } from 'Services';
import { formData } from './FormService';

const save = (data, requestUrl) => {
    const sendObj = {
        url: url.getUrl(requestUrl),
        data,
        type: 'POST',
        processData: false,
        contentType: false,
    };

    return request.sendRequest(sendObj);
};

export const requestOnSubmit = (requestUrl) => async (data) => {
    try {
        const [res] = await save(formData(data), requestUrl);
        return res;
    } catch (error) {
        return error;
    }
};
