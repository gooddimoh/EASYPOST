import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';
import { statusEnumOptions, addressTypeOptions } from 'Services/Enums';

export const getTableLabel = schema({
    name: 'Name',
    type: 'Type',
    date: 'Date',
    status: 'Status',
});

const placeholderRender = schemaFilterRender({
    name: 'Choose name',
    type: 'Choose type',
    date: 'Choose date',
    status: 'Choose status',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    type: () => <InputFilter type="select" inputProps={{ options: addressTypeOptions }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: statusEnumOptions }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
