import React from 'react';
import {schemaFilterRender, schema} from 'Services';
import { Input as InputFilter } from 'Templates/Input';
import { transactionStatusOptions, transactionTypeOptions } from 'Services/Enums';

export const getTableLabel = schema({
    date: 'Date',
    type: 'Type',
    balance: 'Balance',
    user_name: 'User name',
    carrier: 'Carrier',
    description: 'Description',
    status: 'Status',
});

const placeholderRender = schemaFilterRender({
    date: 'Choose date',
    type: 'Type',
    balance: 'Balance',
    user_name: 'User name',
    carrier: 'Carrier',
    description: 'Description',
    status: 'Status',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    type: () => <InputFilter type="select" inputProps={{ options: transactionTypeOptions }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: transactionStatusOptions }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
