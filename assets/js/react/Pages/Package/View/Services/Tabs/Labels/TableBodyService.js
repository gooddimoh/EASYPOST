import React from 'react';
import {formatDate, formatIntToCurrency, getString, schemaCall, getTrackingLink} from 'Services';
import { DefaultSpan } from 'Templates/Content';
import { TableLink } from 'Templates/Table';

export const modifierValues = (items) => items;

export const getViewItem = () =>
    schemaCall({
        date: (item, key) => <DefaultSpan title={formatDate(getString(item, key))} />,
        weight: (item, key) => <DefaultSpan title={`${getString(item, key)} lbs`} />,
        price: (item, key) => <DefaultSpan title={formatIntToCurrency(getString(item, key))} />,
        track: (item, key) => <TableLink title={getString(item, key)} href={getTrackingLink(item.carrier, item.track)} blank />,
        _: (item, key) => <DefaultSpan title={getString(item, key)}/>,
    });
