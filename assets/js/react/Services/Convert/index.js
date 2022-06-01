const toCamel = (s) => {
    return s.replace(/([-_][a-z])/gi, ($1) => {
        return $1.toUpperCase().replace('-', '').replace('_', '');
    });
};

const isArray = (a) => Array.isArray(a);

const isObject = (o) => o === Object(o) && !isArray(o) && typeof o !== 'function';

const toCamelCase = (o) => {
    if (isObject(o)) {
        const n = {};

        Object.keys(o).forEach((k) => {
            n[toCamel(k)] = toCamelCase(o[k]);
        });

        return n;
    }

    if (isArray(o)) {
        return o.map(toCamelCase);
    }

    return o;
};

export {toCamelCase};
