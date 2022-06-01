import React from 'react';
import { schemaFilterRender, schema } from 'Services';
import { EmptyElement } from 'Templates/Content';

export const getTableLabel = schema({
    service_type: 'Service Type',
    amount: 'Amount',
    time_delivery: 'Time Delivery',
});

const placeholderRender = schemaFilterRender({});

export const getFilter = placeholderRender({
    _: () => <EmptyElement />,
});
