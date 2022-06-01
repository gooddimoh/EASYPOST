import * as R from 'ramda';

export const getString = (item, key, defaultValue = '-') => {
    const data = R.path([key], item);

    if (data === undefined || data === null || data === '') {
        return defaultValue;
    }

    return `${ data }`;
};

export const getStringFromList = (value, list, defaultValue = '-') => {
    const item = list.find(elem => elem.value.toString() === value.toString());

    return getString(item, 'label', defaultValue);
};
