import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    children: PropTypes.node.isRequired,
    pref: PropTypes.string.isRequired,
};

const TabBoxColumn = ({ children, pref }) => (
    <div className={`tab-box__column tab-box__column_${pref}`}>{children}</div>
);

TabBoxColumn.propTypes = propTypes;

export default withTagDefaultProps(TabBoxColumn);
