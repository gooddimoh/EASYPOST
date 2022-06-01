import { ValidateDTO, safeValid } from './valide';

export const formErrors = (schema, data) =>
    Object.keys(schema).reduce((acc, field) => {
        if (schema[field]?._tag) {
            acc[field] = schema[field](data[field]);
            return acc;
        }

        if (!Array.isArray(schema[field])) {
            acc[field] = formErrors(schema[field], data[field]);
            return acc;
        }

        acc[field] = schema[field].reduce((err, func) => {
            const res = func(data[field]);
            if (!res.status) err.push(...res.errors);

            return err;
        }, []);

        return acc;
    }, {});

export { ValidateDTO, safeValid };
