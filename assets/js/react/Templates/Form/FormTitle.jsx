import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
};

const FormTitle = ({ pref, t, title }) => {
    return <div className={`form__title form__title_${pref}`}>{t(title)}</div>;
};

FormTitle.propTypes = propTypes;

export default withTagDefaultProps(FormTitle);
