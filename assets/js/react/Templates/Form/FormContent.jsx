import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired
};

const FormContent = ({ pref, children }) => {
    return (
        <div className={`form__content form__content_${pref}`}>
            {children}
        </div>
    );
};

FormContent.propTypes = propTypes;

export default withTagDefaultProps(FormContent);
