import { trim } from 'ramda';
import { required } from '../Rules';
import { formErrors } from '../utils';

export const requireAll = (schema) => {
    const main = (data) => {
        const hasSomeValue = Object.values(data).some(trim);

        if (hasSomeValue) {
            const newSchema = Object.keys(schema).reduce((acc, field) => {
                acc[field] = [...schema[field], required];
                return acc;
            }, {});

            return formErrors(newSchema, data);
        }

        return {};
    };

    main._tag = 'requireAll';

    return main;
};
