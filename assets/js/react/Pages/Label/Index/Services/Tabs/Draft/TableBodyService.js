import React from 'react';
import { getString, schemaCall, formatDate } from 'Services';
import { DefaultSpan } from 'Templates/Content';

export const modifierValues = (items) => items;

export const getViewItem = schemaCall({
    date: (item, key) => <DefaultSpan title={formatDate(getString(item, key))} />,
    weight: (item, key) => <DefaultSpan title={`${getString(item, key)} lbs`} />,
    _: (item, key) => <DefaultSpan title={getString(item, key)} />,
});
