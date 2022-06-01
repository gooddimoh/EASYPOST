import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import service from '../../../Services/Tabs/Package';
import PackagesTable from './PackagesTable';

const PackageTab = () => (
    <ServiceProvider value={service}>
        <PackagesTable />
    </ServiceProvider>
);

export default withTagDefaultProps(PackageTab);
