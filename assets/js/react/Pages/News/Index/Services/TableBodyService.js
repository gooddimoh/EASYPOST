import React from 'react';
import { getString, schemaCall, formatDate, getStringFromList } from 'Services';
import { DefaultSpan, StatusLabel } from 'Templates/Content';
import { statusEnumColorOptions, companyTypeOptions } from 'Services/Enums';
import { TableLink } from 'Templates/Table';

export const modifierValues = (items) => items;

export const getViewItem = (url) =>
    schemaCall({
        name: (item, key) => <TableLink title={getString(item, key)} href={`/${url}/${item.id}`} />,
        type: (item, key) => <DefaultSpan title={getStringFromList(getString(item, key), companyTypeOptions)} />,
        date: (item, key) => <DefaultSpan title={formatDate(getString(item, key))} />,
        status: (item) => <StatusLabel data={statusEnumColorOptions} value={item.status} />,
        _: (item, key) => <DefaultSpan title={getString(item, key)} />,
    });
