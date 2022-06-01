import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const ViewInfoWrap = ({ children, pref }) => (
    <div className={`form-info__wrap form-info__wrap_${pref}`}>{children}</div>
);

ViewInfoWrap.propTypes = propTypes;

export default withTagDefaultProps(ViewInfoWrap);
