import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    children: PropTypes.node.isRequired,
    pref: PropTypes.string.isRequired
};

const Body = ({ pref, children }) => {
    return (
        <div className={`modal__body modal__body_${pref}`}>
            {children}
        </div>
    );
};

Body.propTypes = propTypes;

export default withTagDefaultProps(Body);