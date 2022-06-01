import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    name: PropTypes.string.isRequired,
    type: PropTypes.string,
    disabled: PropTypes.bool,
    placeholder: PropTypes.string,
    value: PropTypes.string,
    className: PropTypes.string,
    inputProps: PropTypes.objectOf(PropTypes.any),
    onChange: PropTypes.func,
    t: PropTypes.func.isRequired,
};

const defaultProps = {
    type: 'text',
    disabled: false,
    placeholder: '',
    value: '',
    className: '',
    onChange: () => {},
    inputProps: {},
};

const DefaultInput = ({ name, type, disabled, placeholder, value, onChange, className, inputProps, t }) => {
    return (
        <input
            id={name}
            name={name}
            type={type}
            disabled={disabled}
            placeholder={t(placeholder)}
            value={value}
            onChange={onChange}
            className={className}
            {...inputProps}
        />
    );
};

DefaultInput.propTypes = propTypes;
DefaultInput.defaultProps = defaultProps;

export default withTagDefaultProps(DefaultInput);
