import { divide } from 'ramda';

export const isNotANumber = (value) => value === '' || Number.isNaN(value) || !Number.isFinite(Number(value));

export const getNumber = (value, rounding = 2) => {
    if (isNotANumber(value)) {
        return 0;
    }
    return Number(value).toFixed(rounding);
};

export const regExpForFloat = (value, cb) => {
    const re = /^[0-9]*[.]?[0-9]{0,2}$/;
    if (re.test(value)) {
        cb(value);
    }
};

export const regExpForInteger = (value, cb) => {
    const re = /^[0-9]*$/;
    if (re.test(value)) {
        cb(value);
    }
};

export const numberWithCommas = (value, rounding = 2) => {
    if (isNotANumber(value)) {
        return 0;
    }
    return Number(Number(value).toFixed(rounding)).toLocaleString('en-US');
};

export const numWithSub = (num, count = 0) => {
    if (count < 9 && num > 1000) {
        return numWithSub(num / 1000, count + 3);
    }

    if (typeof num !== 'number') {
        num = Number(num);
    }
    switch (count) {
        case 0:
            return `${num.toFixed(0)}`;
        case 3:
            return `${numberWithCommas(num * 1000, 0)}`;
        case 6:
            return `${num.toFixed(2)}M`;
        case 9:
            return `${num.toFixed(2)}B`;

        default:
            return '';
    }
};

export const formatIntToCurrency = (price, currency = 'USD') =>
    new Intl.NumberFormat(window.navigator.language, {
        style: 'currency',
        currency,
    }).format(divide(price, 100));
