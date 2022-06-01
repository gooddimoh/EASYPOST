import { pathOr } from 'ramda';

export const formData = (data) => ({
    title: pathOr('', ['title'], data),
    description: pathOr('', ['description'], data),
    link: pathOr('', ['link'], data),
    photo: pathOr('', ['photo'], data),
});
