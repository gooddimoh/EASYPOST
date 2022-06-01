import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    value: PropTypes.string.isRequired,
    checked: PropTypes.bool.isRequired,
    onChange: PropTypes.func.isRequired,
    disabled: PropTypes.bool,
    inputProps: PropTypes.shape({
        label: PropTypes.string.isRequired,
    }).isRequired,
};

const defaultProps = {
    disabled: false,
};

const Radio = ({ pref, name, value, checked, onChange, disabled, inputProps, t }) => {
    const { label } = inputProps;

    return (
        <div className={`radio radio_${pref}`}>
            <input
                className={`radio__input radio__input_${pref}`}
                type="radio"
                id={name}
                name={name}
                value={value}
                checked={checked}
                onChange={onChange}
                disabled={disabled}
            />
            <label htmlFor={name} className={`radio__label radio__label_${pref}`}>
                {t(label)}
            </label>
        </div>
    );
};

Radio.propTypes = propTypes;
Radio.defaultProps = defaultProps;

export default withTagDefaultProps(Radio);
