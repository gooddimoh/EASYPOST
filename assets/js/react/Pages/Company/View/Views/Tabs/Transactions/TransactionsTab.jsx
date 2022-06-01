import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import { TabBox, TabBoxColumn } from 'Templates/Tabs';
import service from '../../../Services/Tabs/Transactions';
import TableView from '../../TableView';

const TransactionTab = () => {

    return (
        <ServiceProvider value={service}>
            <TabBox>
                <TabBoxColumn>
                    <div className="tab-box__title">total:</div>
                </TabBoxColumn>
            </TabBox>
            <TableView />
        </ServiceProvider>
    );
};

export default withTagDefaultProps(TransactionTab);
