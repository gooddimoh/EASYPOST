import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { Tabs, TabWrap } from 'Templates/Tabs';
import { LabelsTab, TransactionsTab, UsersTab } from './Tabs';

const propTypes = {
    activeTab: PropTypes.number.isRequired,
    onClickTab: PropTypes.func.isRequired,
};

const MainBlock = ({ activeTab, onClickTab }) => {
    return (
        <Tabs activeTab={activeTab} onClick={onClickTab}>
            <TabWrap label="User">
                <UsersTab/>
            </TabWrap>
            <TabWrap label="Label">
                <LabelsTab/>
            </TabWrap>
            <TabWrap label="Transactions">
                <TransactionsTab/>
            </TabWrap>
        </Tabs>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        activeTab: getStoreItem(state, 'activeTab', 0),
        id: getStoreItem(state, ['view', 'id'], 0),
    };
};

const mapDispatchToProps = ({ service: { getActionStore }, id }) => {
    return {
        onClickTab: getActionStore('onClickTab', id),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
