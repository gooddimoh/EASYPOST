import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';

export const getTableLabel = schema({
    date: 'Date',
    sender: 'Sender',
    recipient: 'Recipient',
    weight: 'Weight',
    service: 'Service',
    carrier: 'Carrier',
    track: 'Track',
    price: 'Price',
    pickup_price: 'Pickup price',
});

const placeholderRender = schemaFilterRender({
    date: 'Choose date',
    sender: 'Sender',
    recipient: 'Recipient',
    weight: 'Weight',
    service: 'Service',
    carrier: 'Carrier',
    track: 'Track',
    price: 'Price',
    pickup_price: 'Pickup price',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
