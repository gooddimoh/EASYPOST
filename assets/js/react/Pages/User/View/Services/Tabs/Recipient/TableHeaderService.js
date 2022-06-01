import React from 'react';
import { countryList, schema, schemaFilterRender } from 'Services';
import { statusEnumOptions } from 'Services/Enums';
import { Input as InputFilter } from 'Templates/Input';

export const getTableLabel = schema({
    name: 'Name',
    date: 'Date',
    phone: 'Phone',
    email: 'Email',
    street1: 'Address 1',
    street2: 'Address 2',
    city: 'City',
    state: 'State',
    country: 'Country',
    zip: 'Zip',
    description: 'Description',
    status: 'Status',
});

const placeholderRender = schemaFilterRender({
    name: 'Name',
    date: 'Date',
    phone: 'Phone',
    email: 'Email',
    street1: 'Address 1',
    street2: 'Address 2',
    city: 'City',
    state: 'State',
    country: 'Country',
    zip: 'Zip',
    description: 'Description',
    status: 'Status',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" />,
    country: () => <InputFilter type="select" inputProps={{ options: countryList }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: statusEnumOptions }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
