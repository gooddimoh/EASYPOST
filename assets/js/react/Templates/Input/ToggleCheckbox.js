import React from "react";
import * as R from 'ramda';
import PropTypes from "prop-types";

const propTypes = {
    value: PropTypes.string,
    disabled: PropTypes.bool,
    name: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.objectOf(PropTypes.any),
};

const defaultProps = {
    disabled: false,
    value: "",
    inputProps: {
        checked: false,
    },
};

const ToggleCheckbox = ({ value, onChange, inputProps, disabled, name }) => {

    const { checked } = inputProps;
    inputProps = R.dissocPath(['checked'], inputProps);

    return (
        <input
            id={name}
            name={name}
            type="checkbox"
            disabled={disabled}
            checked={checked}
            value={value}
            onChange={onChange}
            {...inputProps}
        />
    );
};

ToggleCheckbox.propTypes = propTypes;
ToggleCheckbox.defaultProps = defaultProps;

export default ToggleCheckbox;
