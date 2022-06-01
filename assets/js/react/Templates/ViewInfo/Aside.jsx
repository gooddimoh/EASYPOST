import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const Aside = ({ children, pref }) => <div className={`form-info__profile form-info__profile_${pref}`}>{children}</div>;

Aside.propTypes = propTypes;

export default withTagDefaultProps(Aside);
