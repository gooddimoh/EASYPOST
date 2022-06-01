import * as R from 'ramda';
import { uniqueGenerator } from './UniqueGenerator';
import RequestComopps from './Request';
import { cacheRequest } from './Cache';
import {
    changeFilter,
    generateKeyRender,
    getActionStore,
    getStoreItem,
    replaceFilter,
    schema,
    pathToValue,
    schemaCall,
    schemaFilterRender,
    schemaReducer,
} from './Store';
import UrlHelper, { storageUrl } from './Url';
import attachFile from './FileService';
import { eventFrame, handleScroll, handleScrollRevert, onChange } from './EventsService';
import { countryList, countryListObj, phoneList, StateList, stateListObj } from './ListService';
import {
    getNumber,
    isNotANumber,
    numberWithCommas,
    numWithSub,
    regExpForFloat,
    regExpForInteger,
    formatIntToCurrency,
} from './NumberService';
import { getString, getStringFromList } from './StringService';
import { notEmptyArray } from './ArrayService';
import {
    diffBetweenDays,
    diffDate,
    duration,
    formatDate,
    formatDateAddUtcOffset,
    formatDateUtc,
    unix,
    formatFirstDayMonth,
    defaultRangeDays,
    formatMaxDay30,
    checkInvalidDate,
} from './DateService';
import { md5, sha1 } from './Hash';
import { mapKeys } from './Utils';
import { getTrackingLink } from './Tracking';

export const request = new RequestComopps(cacheRequest);
export const url = new UrlHelper();

export const snakeToCamel = (str) =>
    str.replace(/([-_][a-z])/g, (group) => group.toUpperCase().replace('-', '').replace('_', ''));

export const maxSizeCanvas = (width) => (width < 16000 ? width : 16000);

export const formDataNormalizer = (data) => {
    const formData = new FormData();

    const formDataAppend = (key, value) => {
        formData.append(key, value);
    };

    const formDataMap = (dataReq, root = '') => {
        dataReq.forEach((value, key) => {
            // eslint-disable-next-line no-use-before-define
            formDataItem(value, `${root}[${key}]`);
        });
    };

    const formDataItem = (value, key) => {
        // TODO need ramda here
        if (Array.isArray(value)) {
            formDataMap(value, key);
            return;
        }

        if (typeof value === 'boolean') {
            switch (value) {
                case true:
                    formDataAppend(key, 10);
                    break;

                default:
                    formDataAppend(key, 0);
                    break;
            }
            return;
        }

        if (R.is(Blob, value)) {
            formDataAppend(`${key}`, value);
            return;
        }

        if (R.is(Object, value)) {
            mapKeys(value, (val, k) => {
                formDataItem(val, `${key}[${k}]`);
            });
        } else {
            formDataAppend(`${key}`, value);
        }
    };

    mapKeys(data, (value, key) => {
        formDataItem(value, key);
    });

    return formData;
};

export const isEqual = (obj1, obj2, keys) => {
    const val1 = R.pick(keys, obj1);
    const val2 = R.pick(keys, obj2);

    return R.equals(val1, val2);
};

export const isString = (x) => Object.prototype.toString.call(x) === '[object String]';

export const hex2rgba = (hex, alpha = 1) => {
    if (hex) {
        const [r, g, b] = hex.match(/\w\w/g).map((x) => parseInt(x, 16));
        return `rgba(${r},${g},${b},${alpha})`;
    }
    return 'transparent';
};

export const arrayReverse = (arr) => (Array.isArray(arr) ? arr.reverse() : []);

export const toBase64 = (file) =>
    new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
    });

export const storagePref = '/storage';

export const serviceProps = R.curry((href, pref, options) => ({ ...options, pref, url: href }));

export const randomColor = () => Math.floor(Math.random() * 16777215).toString(16);

/**
 * @deprecated
 * @param e
 */
const throwError = (e) => {
    throw e;
};

export {
    changeFilter,
    getStoreItem,
    replaceFilter,
    getActionStore,
    generateKeyRender,
    StateList,
    attachFile,
    stateListObj,
    countryListObj,
    countryList,
    phoneList,
    unix,
    duration,
    getString,
    getStringFromList,
    isNotANumber,
    getNumber,
    notEmptyArray,
    regExpForFloat,
    regExpForInteger,
    formatIntToCurrency,
    numberWithCommas,
    numWithSub,
    formatDate,
    formatDateUtc,
    formatDateAddUtcOffset,
    diffDate,
    formatFirstDayMonth,
    defaultRangeDays,
    formatMaxDay30,
    checkInvalidDate,
    storageUrl,
    uniqueGenerator,
    eventFrame,
    handleScroll,
    onChange,
    handleScrollRevert,
    diffBetweenDays,
    md5,
    sha1,
    schemaFilterRender,
    schema,
    schemaCall,
    schemaReducer,
    throwError,
    pathToValue,
    getTrackingLink,
};
