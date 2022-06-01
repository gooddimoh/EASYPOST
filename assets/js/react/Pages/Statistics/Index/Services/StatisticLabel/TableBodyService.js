import React from 'react';
import { formatIntToCurrency, getString, schemaCall } from 'Services';
import { DefaultSpan } from 'Templates/Content';

export const modifierValues = (items) => items;

export const getViewItem = () =>
    schemaCall({
        name: (item, key) => <DefaultSpan title={getString(item, key)}/>,
        _: (item, key) => <DefaultSpan title={formatIntToCurrency(getString(item, key))}/>,
    });
