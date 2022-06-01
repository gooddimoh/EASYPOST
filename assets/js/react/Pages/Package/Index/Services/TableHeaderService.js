import React from 'react';
import {schemaFilterRender, schema} from 'Services';
import {Input as InputFilter} from 'Templates/Input';
import {statusEnumOptions} from 'Services/Enums';

export const getTableLabel = schema({
    date: 'Date',
    name: 'Name',
    price_month: 'Month price',
    price_label: 'Label price',
    status: 'Status',
});

const placeholderRender = schemaFilterRender({
    date: 'Choose date',
    name: 'Choose name',
    price_month: 'Choose month price',
    price_label: 'Choose label price',
    status: 'Choose status',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: statusEnumOptions }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
