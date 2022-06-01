import React from "react";
import PropTypes from "prop-types";

const propTypes = {
    onClick: PropTypes.func.isRequired,
    show: PropTypes.bool.isRequired,
};

const CustomOverlay = ({ onClick, show }) => {
    return (
        <div
            className={`custom-bg ${!show ? "active" : ""}`}
            onClick={onClick}
            onKeyDown={onClick}
        />
    );
};

CustomOverlay.propTypes = propTypes;

export default CustomOverlay;
