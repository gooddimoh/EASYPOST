import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';

export const getTableLabel = schema({
    date: 'Date',
    balance: 'Balance',
    description: 'Description',
});

const placeholderRender = schemaFilterRender({
    date: 'Choose date',
    balance: 'Balance',
    description: 'Description',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
