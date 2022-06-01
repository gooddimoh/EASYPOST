import React from 'react';
import { schema, schemaFilterRender } from 'Services';
import { Input as InputFilter } from 'Templates/Input';
import { roleOptions, statusEnumOptions } from 'Services/Enums';

export const getTableLabel = schema({
    name: 'Full name',
    email: 'Email',
    role: 'Role',
    status: 'Status',
    company: 'Company',
});

const placeholderRender = schemaFilterRender({
    name: 'Full name',
    email: 'Email',
    role: 'Role',
    status: 'Status',
    company: 'Company',
});

export const getFilter = placeholderRender({
    role: () => <InputFilter type="select" inputProps={{ options: roleOptions }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: statusEnumOptions }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
