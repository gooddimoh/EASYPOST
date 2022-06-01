import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';
import { statusEnumOptions } from 'Services/Enums';

export const getTableLabel = schema({
    title: 'Title',
    date: 'Date',
    description: 'Description',
    status: 'Status',
});

const placeholderRender = schemaFilterRender({
    title: 'Choose title',
    date: 'Choose date',
    description: 'Choose description',
    status: 'Choose status',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: statusEnumOptions }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
