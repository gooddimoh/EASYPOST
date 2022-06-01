import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';

export const getTableLabel = schema({
    date: 'Date',
    sender: 'Sender',
    recipient: 'Recipient',
    weight: 'Weight',
    service: 'Service',
    track: 'Track',
    rate: 'Rate',
});

const placeholderRender = schemaFilterRender({
    date: 'Choose date',
    sender: 'Sender',
    recipient: 'Recipient',
    weight: 'Weight',
    service: 'Service',
    track: 'Track',
    rate: 'Rate',
});

export const getFilter = placeholderRender({
    date: () => <InputFilter type="date" inputProps={{ viewFormat: 'DD.MM' }} />,
    _: () => <InputFilter type="magnifyGlass" />,
});
