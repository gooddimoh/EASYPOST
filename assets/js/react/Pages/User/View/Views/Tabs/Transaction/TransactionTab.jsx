import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import { TableWidget } from 'Widgets/Table';
import service from '../../../Services/Tabs/Transaction';

const TransactionTab = () => {
    return (
        <ServiceProvider value={service}>
            <TableWidget />
        </ServiceProvider>
    );
};

export default withTagDefaultProps(TransactionTab);
