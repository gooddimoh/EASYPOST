import {formErrors} from '../utils';

export const arrayOf = (schema) => {
    const main = (data) => data.map((i) => formErrors(schema, i));
    main._tag = 'arrayOf';

    return main;
};
