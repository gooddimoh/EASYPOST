import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    children: PropTypes.node.isRequired,
    pref: PropTypes.string.isRequired,
};

const TabBox = ({ children, pref }) => <div className={`tab-box tab-box_${pref}`}>{children}</div>;

TabBox.propTypes = propTypes;

export default withTagDefaultProps(TabBox);
