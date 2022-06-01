import React from 'react';
import { getString, schemaCall } from 'Services';
import { TableLink } from 'Templates/Table';
import { DefaultSpan, RowLabel, StatusLabel } from 'Templates/Content';
import { roleOptions, statusEnumColorOptions } from 'Services/Enums';

export const modifierValues = (items) => items;

export const getViewItem = (url) =>
    schemaCall({
        name: (item, key) => <TableLink title={getString(item, key)} href={`/${url}/${item.id}`} />,
        email: (item, key) => <TableLink title={getString(item, key)} href={`mailto:${getString(item, key)}`} />,
        role: (item, key) => <RowLabel data={roleOptions} value={getString(item, key)} />,
        company: (item, key) => <TableLink title={getString(item, key)} href={`/companies/${item.company_id}`} />,
        status: (item) => <StatusLabel data={statusEnumColorOptions} value={item.status} />,
        _: (item, key) => <DefaultSpan title={getString(item, key)}/>,
    });
