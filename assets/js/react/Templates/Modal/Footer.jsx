import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';

const propTypes = {
    buttons: PropTypes.arrayOf(PropTypes.node).isRequired
};

const Footer = ({ buttons, pref }) => {
    return (
        <div className={`modal__footer modal__footer_${pref}`}>
            {buttons}
        </div>
    );
};

Footer.propTypes = propTypes;

export default withTagDefaultProps(Footer);