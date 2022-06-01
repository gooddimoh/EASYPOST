import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    name: PropTypes.string,
    label: PropTypes.string,
    children: PropTypes.node,
    required: PropTypes.bool,
};

const defaultProps = {
    name: '',
    label: '',
    children: null,
    required: false,
};

const Label = ({ pref, name, label, t, children, required }) => (
    <label htmlFor={name} className={`label label_${pref} ${required ? 'required' : ''}`}>
        {t(label)}
        {children}
    </label>
);

Label.propTypes = propTypes;
Label.defaultProps = defaultProps;

export default withTagDefaultProps(Label);
