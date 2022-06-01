import React from 'react';
import { ServiceProvider } from 'Services/Context';
import { TabBox, TabBoxColumn } from 'Templates/Tabs';
import service from '../../../Services/Tabs/Labels';
import TableView from '../../TableView';

const LabelTab = () => {

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

export default LabelTab;
