import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const FormFooter = ({ pref, children }) => {
    return <div className={`form__footer form__footer_${pref}`}>{children}</div>;
};

FormFooter.propTypes = propTypes;

export default withTagDefaultProps(FormFooter);
