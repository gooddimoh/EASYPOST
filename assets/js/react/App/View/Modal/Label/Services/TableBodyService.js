import React from 'react';
import { getString, schemaCall, formatIntToCurrency } from 'Services';
import { DefaultSpan } from 'Templates/Content';
import { ServiceTypeRow } from '../Templates';

export const modifierValues = (items) => items;

export const getViewItem = schemaCall({
    service_type: (item) => <ServiceTypeRow item={item} />,
    amount: (item, key) => <DefaultSpan title={formatIntToCurrency(getString(item, key))} />,
    time_delivery: (item, key) => <DefaultSpan title={`${getString(item, key)} day(s)`} />,
    _: (item, key) => <DefaultSpan title={getString(item, key)} />,
});
