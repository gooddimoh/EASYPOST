import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';

momentDurationFormatSetup(moment);

export const formatDate = (date, format = 'DD/MM/YYYY', utc = true) => {
    if (!date) return null;

    if (utc) {
        const stillUtc = moment.utc(date).toDate();
        return moment(stillUtc).locale('ru').format(format);
    }

    return moment(date).locale('ru').local().format(format);
};

export const formatFirstDayMonth = () => {
    const date = new Date();
    const firstDayMonth = new Date(date.getFullYear(), date.getMonth(), 1);

    return moment(firstDayMonth).format("YYYY-MM-DD");
};

export const defaultRangeDays = () => [formatFirstDayMonth(), formatDate(new Date(), "YYYY-MM-DD")];

export const formatMaxDay30 = (value) => {
    const myDate = (date) => new Date(date);

    return myDate(moment(myDate(value).setDate(myDate(value).getDate() + 30)));
};

export const checkInvalidDate = (date) => {
    if(formatMaxDay30(date).toString() === 'Invalid Date') {
        return new Date();
    }
    if(formatMaxDay30(date).getTime() >= new Date().getTime()) {
        return new Date();
    }
    return formatMaxDay30(date);
};

export const formatDateUtc = (date, format = 'DD/MM/YYYY', utc = true) => {
    if (!date) {
        return moment.utc().format(format);
    }
    return formatDate(date, format, utc);
};

export const formatDateAddUtcOffset = (date, format = 'll') => {
    return moment.utc(date).add(moment().utcOffset(), 'minutes').format(format);
};

export const diffDate = (date, _diffDate, unitOfTime = 'days') => {
    date = date ? moment(date) : moment();
    _diffDate = _diffDate ? moment(_diffDate) : moment();
    return date.diff(_diffDate, unitOfTime);
};

export const unix = (date) => {
    return moment.unix(date / 1000);
};

export const duration = (time, type = 'seconds', format = 'mm:ss') => {
    const _duration = moment.duration(time, type);
    return _duration.format(format);
};

export const addTimeToDate = (startStr, durationStr) => {
    const format = 'YYYY-MM-DD HH:mm:ss';
    const [hour, minute] = durationStr.split(':');
    return moment(startStr).add(hour, 'h').add(minute, 'm').format(format);
};

export const diffBetweenDays = (prev, current) => {
    if (!prev || !current) return -10;
    const format = 'DD-MM-YYYY';
    const admission = moment(moment.utc(prev).format(format), format);
    const discharge = moment(moment.utc(current).format(format), format);
    return admission.diff(discharge, 'days');
};
