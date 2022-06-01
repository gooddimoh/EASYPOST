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

const RoundedButton = ({ name, type, disabled, onClick, children, pref, fullWidth }) => {
    return (
        <button
            aria-label={name}
            type={type}
            disabled={disabled}
            onClick={onClick}
            className={`button button_${pref} button_radius ${fullWidth ? "button_fullwidth" : ""}`}
        >
            {children}
        </button>
    );
};

RoundedButton.propTypes = propTypes;
RoundedButton.defaultProps = defaultProps;

export default withTagDefaultProps(RoundedButton);
