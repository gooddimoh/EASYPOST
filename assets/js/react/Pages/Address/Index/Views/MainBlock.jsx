import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { Tabs, TabWrap } from 'Templates/Tabs';
import { SenderTab, RecipientTab } from './Tabs';

const propTypes = {
    activeTab: PropTypes.number.isRequired,
    onClickTab: PropTypes.func.isRequired,
};

const MainBlock = ({ activeTab, onClickTab }) => {
    return (
        <Tabs activeTab={activeTab} onClick={onClickTab}>
            <TabWrap label="Senders">
                <SenderTab />
            </TabWrap>
            <TabWrap label="Recipients">
                <RecipientTab />
            </TabWrap>
        </Tabs>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        activeTab: getStoreItem(state, 'activeTab', 0),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onClickTab: getActionStore('onClickTab'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
