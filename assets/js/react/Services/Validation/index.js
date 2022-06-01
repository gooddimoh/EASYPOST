import { assocPath, is, equals } from 'ramda';
import { numbers, required, email, moreThanOne, money } from './Rules';
import { arrayOf, requireAll } from './Types';
import { formErrors } from './utils';

const validForm = (config) => (form) => {
    const errors = formErrors(config, form);

    const checkErrors = (obj) => {
        return Object.values(obj).some((item) => {
            if (!Array.isArray(item)) return checkErrors(item);
            if (equals(typeof item[0], 'string')) return !!item.length;
            return item.some((i) => checkErrors(i));
        });
    };

    const hasErrors = checkErrors(errors);

    return {
        formValidate: !hasErrors,
        formErrors: errors,
    };
};

/**
 * @deprecated
 * @param func
 * @returns {function({state?: *, data: *}): *|(function(*=, *=): (*))|(function(*=): (*))}
 */
const validFormOnChange =
    (func) =>
    ({ state, data }) => {
        console.warn('Using validFormOnChange function, validation module should be refactored!');
        if (!is(Array, data.key)) data.key = [data.key]; // TODO need ramda here
        const newState = assocPath(data.key, data.value, state);
        newState.formValidate = func(newState);
        return newState;
    };

export { validForm, validFormOnChange, numbers, required, email, moreThanOne, money, arrayOf, requireAll };
