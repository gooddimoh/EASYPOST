import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    name: PropTypes.string.isRequired,
    type: PropTypes.string,
    disabled: PropTypes.bool,
    onClick: PropTypes.func,
    children: PropTypes.node,
    pref: PropTypes.string.isRequired,
    fullWidth: PropTypes.bool,
};

const defaultProps = {
    type: "button",
    disabled: false,
    onClick: () => {},
    children: null,
    fullWidth: false,
};

const DefaultButton = ({ name, type, disabled, onClick, children, pref, fullWidth }) => {
    return (
        <button
            aria-label={name}
            type={type}
            disabled={disabled}
            onClick={onClick}
            className={`button button_default button_${pref} ${fullWidth ? "button_fullwidth" : ""}`}
        >
            {children}
        </button>
    );
};

DefaultButton.propTypes = propTypes;
DefaultButton.defaultProps = defaultProps;

export default withTagDefaultProps(DefaultButton);
