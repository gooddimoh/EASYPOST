import axios from 'axios';
import {pathOr} from 'ramda';
import {ErrorNotification} from 'Widgets/NotificationWrap';
import {url as urlService, formDataNormalizer} from 'Services';

export default function Request(cacheRequest) {

    this.delayClass = 'ajax-delay';

    this.main = document.body;

    this.sendRequestData = (obj) => {
        return new Promise((resolve, reject) => {
            this.sendRequest(obj, false).then((data) => {
                resolve({ header: data[1], data: data[0] });
            }, reject);
        });
    };

    this.sendRequest = async (obj, delay = true, notification = true) => {
        const getCacheKey = ({ url, data }) => `${url}?${urlService.queryParamEncode(data)}`;

        if (delay) {
            if (this.main.classList.contains(this.delayClass)) {
                return [];
            }
            this.main.classList.add(this.delayClass);
        }

        if (!delay && obj.type.toLowerCase() === 'get') {
            const cacheKey = getCacheKey(obj);
            const dataFromTheCache = cacheRequest.get(cacheKey);
            if (dataFromTheCache) {
                setTimeout(() => {
                    this.main.classList.remove(this.delayClass);
                }, 0);

                return [];
            }
        }

        const configRequest = {};

        if (obj.type.toUpperCase() === 'GET') {
            configRequest.params = { ...obj.data };
            configRequest.paramsSerializer = (params) => urlService.queryParamEncode(params);
        } else if (!obj.contentType) {
            configRequest.data = formDataNormalizer(obj.data);
        }

        try {
            const { data, request } = await axios({
                ...configRequest,
                method: obj.type,
                url: obj.url,
                responseType: obj.dataType || 'json',
                processData: obj.processData || true,
                contentType: obj.contentType || 'application/x-www-form-urlencoded; charset=UTF-8',
            });
            const successRequestStatus = 200;
            if (request.status === successRequestStatus) {
                if (obj.type.toLowerCase() === 'get') {
                    const cacheKey = getCacheKey(obj);
                    cacheRequest.set(cacheKey, [data.message, request]);
                }
            }

            return [data.message, request];
        } catch (error) {
            const err = pathOr('Error.', ['response', 'data', 'errors'], error);

            if (notification) {
                ErrorNotification({
                    title: err.title,
                    text: err.detail,
                });
            }

            throw err;
        } finally {
            this.main.classList.remove(this.delayClass);
        }
    };
}
