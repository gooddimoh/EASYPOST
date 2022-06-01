import React from "react";
import PropTypes from 'prop-types';

const propTypes = {
    error: PropTypes.objectOf(PropTypes.any).isRequired,
};

const ErrorIndicator = ({ error }) => {
    return (
        <div>
            <div>ErrorIndicator</div>
            <div>{error.toString()}</div>
        </div>
    );
};

ErrorIndicator.propTypes = propTypes;

export default ErrorIndicator;
