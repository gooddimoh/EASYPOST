import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
};

const FormError = ({ pref, title, t }) => {
    return <div className={`form__error form__error_${pref}`}>{t(title)}</div>;
};

FormError.propTypes = propTypes;

export default withTagDefaultProps(FormError);
