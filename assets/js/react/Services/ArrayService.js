export const notEmptyArray = (array, defaultValue) => {

    if (Array.isArray(array) && array.length) {
        return array;
    }

    return defaultValue;
};
