import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';

export const getTableLabel = schema({
    date: 'Date',
    recipient: 'Recipient',
    sender: 'Sender',
    weight: 'Weight',
    service: 'Service',
    carrier: 'Carrier',
    track: 'Track',
    rate: 'Rate',
    price: 'Price',
    pickup_price: 'Pickup price'
});

const placeholderRender = schemaFilterRender({
    date: 'Choose date',
    recipient: 'Recipient',
    sender: 'Sender',
    weight: 'Weight',
    service: 'Service',
    carrier: 'Carrier',
    track: 'Track',
    rate: 'Rate',
    price: 'Price',
    pickup_price: 'Pickup price'
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
