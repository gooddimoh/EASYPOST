import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    show: PropTypes.bool.isRequired,
    pref: PropTypes.string.isRequired,
};

const Spinloader = ({ show, pref }) => <span className={`spinner spinner_${pref} ${show ? 'spinner_show' : ''}`} />;

Spinloader.propTypes = propTypes;

export default withTagDefaultProps(Spinloader);
