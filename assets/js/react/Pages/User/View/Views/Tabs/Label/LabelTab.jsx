import React from 'react';
import { ServiceProvider } from 'Services/Context';
import { TableWidget } from 'Widgets/Table';
import service from '../../../Services/Tabs/Label';

const LabelTab = () => {
    return (
        <ServiceProvider value={service}>
            <TableWidget />
        </ServiceProvider>
    );
};

export default LabelTab;
