import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { EmptyElement } from 'Templates/Content';

export const getTableLabel = schema({
    title: ' ',
    price: ' ',
    usps: 'USPS',
    ups: 'UPS',
    fedex: 'FedEx',
    useFedex: 'Using your own Fedex account',
    useUps: 'Using your own UPS account',
    pickup: 'Pickup services',
    rates: 'Rates',
});

const placeholderRender = schemaFilterRender({});

export const getFilter = placeholderRender({
    _: () => <EmptyElement />,
});
