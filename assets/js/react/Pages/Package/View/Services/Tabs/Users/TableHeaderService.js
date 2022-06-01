import React from 'react';
import { schema, schemaFilterRender } from 'Services';
import { Input as InputFilter } from 'Templates/Input';
import { roleOptions, userStatus } from 'Services/Enums';

export const getTableLabel = schema({
    name_first: 'First name',
    name_last: 'Last name',
    email: 'Email',
    role: 'Role',
    status: 'Status',
    company: 'Company',
});

const placeholderRender = schemaFilterRender({
    name_first: 'First name',
    name_last: 'Last name',
    email: 'Email',
    role: 'Role',
    status: 'Status',
    company: 'Company',
});

export const getFilter = placeholderRender({
    role: () => <InputFilter type="select" inputProps={{ options: roleOptions }} />,
    status: () => <InputFilter type="multiSelect" inputProps={{ options: userStatus }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
