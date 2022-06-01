import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    children: PropTypes.node.isRequired,
    pref: PropTypes.string.isRequired
};

const ButtonsWrap = ({ children, pref }) => {
    return (
        <div className={`button_wrap button_wrap_${pref}`}>
            {children}
        </div>
    );
};

ButtonsWrap.propTypes = propTypes;

export default withTagDefaultProps(ButtonsWrap);