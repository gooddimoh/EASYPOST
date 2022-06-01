import { pathOr } from 'ramda';

export const formData = (data) => ({
    name: pathOr('', ['name'], data),
    type: pathOr('', ['type'], data),
    photo: pathOr('', ['photo'], data),
});
