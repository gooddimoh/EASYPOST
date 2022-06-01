export const isPlainObject = (obj) => {
    return Object.keys(obj).some((item) => typeof obj[item] === 'object');
};

export const mapKeys = (obj, fn) => {
    const result = {};

    Object.keys(obj).forEach((key) => {
        result[fn(obj[key], key, obj)] = obj[key];
    });

    return result;
};
