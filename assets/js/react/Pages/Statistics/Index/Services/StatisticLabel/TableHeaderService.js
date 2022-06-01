import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { Input as InputFilter } from 'Templates/Input';

export const getTableLabel = schema({
    name: 'Full name',
    usps_spent: 'USPS',
    fedex_spent: 'Fedex',
    ups_spent: 'UPS',
    total_spent: 'Total spent',
    total_profit: 'Total profit',
});

const placeholderRender = schemaFilterRender({
    name: 'Full name',
});

export const getFilter = placeholderRender({
    name: () => <InputFilter type="magnifyGlass" />,
    _: () => <div />,
});
