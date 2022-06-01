import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const FormBody = ({ pref, children }) => {
    return <div className={`form__body form__body_${pref}`}>{children}</div>;
};

FormBody.propTypes = propTypes;

export default withTagDefaultProps(FormBody);
