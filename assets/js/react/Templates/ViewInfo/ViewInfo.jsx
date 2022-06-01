import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const ViewInfo = ({ children, pref }) => <div className={`form-info form-info_${pref}`}>{children}</div>;

ViewInfo.propTypes = propTypes;

export default withTagDefaultProps(ViewInfo);
