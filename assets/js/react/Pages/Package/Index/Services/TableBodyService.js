import React from 'react';
import { getString, schemaCall, formatDate, formatIntToCurrency } from 'Services';
import {DefaultSpan, StatusLabel} from 'Templates/Content';
import { statusEnumColorOptions } from 'Services/Enums';

export const modifierValues = (items) => items;

export const getViewItem = () => schemaCall({
    status: item => <StatusLabel data={ statusEnumColorOptions } value={item.status}/>,
    date: (item, key) => <DefaultSpan title={formatDate(getString(item, key))} />,
    price_label: (item, key) => <DefaultSpan title={formatIntToCurrency(getString(item, key))}/>,
    price_month: (item, key) => <DefaultSpan title={formatIntToCurrency(getString(item, key))}/>,
    _: (item, key) => <DefaultSpan title={getString(item, key)}/>,
});
