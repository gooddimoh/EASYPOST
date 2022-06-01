import React from 'react';
import { getString, schemaCall, formatIntToCurrency } from 'Services';
import { permissionsEnum } from 'Services/Enums';
import { DefaultSpan } from 'Templates/Content';

export const modifierValues = (items) => items;

const check = (cond, arr) => (arr.includes(cond) ? '+' : '-');

export const getViewItem = schemaCall({
    title: (item) => <DefaultSpan title={getString(item, 'name')} />,
    price: (item) => {
        const string = (a, b) => {
            if (a && !b) {
                return `${formatIntToCurrency(getString(item, 'price_month'))}/month`;
            }
            if (!a && b) {
                return `Just ${formatIntToCurrency(getString(item, 'price_label'))} label`;
            }
            return `${formatIntToCurrency(getString(item, 'price_month'))}/month + ${formatIntToCurrency(
                getString(item, 'price_label'),
            )} label`;
        };
        return <DefaultSpan title={string(item.price_month, item.price_label)} />;
    },
    usps: (item) => <DefaultSpan title={check(permissionsEnum.useUsps, item.permissions)} />,
    ups: (item) => <DefaultSpan title={check(permissionsEnum.useUps, item.permissions)} />,
    fedex: (item) => <DefaultSpan title={check(permissionsEnum.useFedex, item.permissions)} />,
    useFedex: (item) => <DefaultSpan title={check(permissionsEnum.fedex, item.permissions)} />,
    useUps: (item) => <DefaultSpan title={check(permissionsEnum.ups, item.permissions)} />,
    pickup: (item) => <DefaultSpan title={check(permissionsEnum.pickup, item.permissions)} />,
    _: (item, key) => <DefaultSpan title={getString(item, key)} />,
});
