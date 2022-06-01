import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const ViewInfoSidebar = ({ children, pref }) => (
    <div className={`form-info__block form-info__block--small form-info__block_${pref}`}>{children}</div>
);

ViewInfoSidebar.propTypes = propTypes;

export default withTagDefaultProps(ViewInfoSidebar);
