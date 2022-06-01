import { diffDate } from 'Services/DateService';
import { lensPath, over, replace, view, when } from 'ramda';

export const check20dayTerms = (item) => (diffDate(item.date) <= 20);

const lens = lensPath(['filter', 'price']);

export const responseNormalizer = when(
    view(lens),
    over(lens, replace(/[\s.,%]/g, '')),
);
