import React from 'react';
import { countryListObj, formatDate, getString, schemaCall } from 'Services';
import { DefaultSpan, StatusLabel } from 'Templates/Content';
import { statusEnumColorOptions } from 'Services/Enums';
import { TableLink } from 'Templates/Table';

export const modifierValues = (items) => items;

export const getViewItem = schemaCall({
    email: (item, key) => <TableLink title={getString(item, key)} href={`mailto:${getString(item, key)}`} />,
    status: (item, key) => <StatusLabel data={statusEnumColorOptions} value={item[key]} />,
    country: (item, key) => {
        const country = countryListObj[getString(item, key)];
        return <DefaultSpan title={country}/>;
    },
    date: (item, key) => {
        const date = formatDate(getString(item, key));
        return <DefaultSpan title={date}/>;
    },
    _: (item, key) => <DefaultSpan title={getString(item, key)}/>,
});
