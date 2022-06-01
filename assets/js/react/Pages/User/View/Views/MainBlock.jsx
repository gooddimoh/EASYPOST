import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { permissionsEnum } from 'Services/Enums';
import { Tabs, TabWrap } from 'Templates/Tabs';
import { LabelTab, SenderTab, RecipientTab, TransactionTab, PackageTab } from './Tabs';

const propTypes = {
    activeTab: PropTypes.number.isRequired,
    onClickTab: PropTypes.func.isRequired,
};

const schema = {
    sender: { type: 1 },
    recipient: { type: 2 },
    _: {},
};

const MainBlock = ({ activeTab, onClickTab }) => {
    const onClick = (index, key) => onClickTab(index, schema[key] || schema._);

    return (
        <Tabs activeTab={activeTab} onClick={onClick}>
            <TabWrap label="Labels">
                <LabelTab />
            </TabWrap>
            <TabWrap label="Senders" param="sender">
                <SenderTab />
            </TabWrap>
            <TabWrap label="Recipients" param="recipient">
                <RecipientTab />
            </TabWrap>
            <TabWrap label="Transactions">
                <TransactionTab />
            </TabWrap>
            <TabWrap label="Packages" permission={[permissionsEnum.single_person]}>
                <PackageTab />
            </TabWrap>
        </Tabs>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        userId: getStoreItem(state, ['view', 'id'], ''),
        activeTab: getStoreItem(state, 'activeTab', 0),
    };
};

const mapDispatchToProps = ({ service: { getActionStore }, userId }) => {
    return {
        onClickTab: getActionStore('onClickTab', userId),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
