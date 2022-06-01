import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    src: PropTypes.string.isRequired,
    pref: PropTypes.string.isRequired,
    children: PropTypes.node,
    blank: PropTypes.bool,
};

const defaultProps = {
    children: null,
    blank: false,
};

const DefaultButtonLink = ({ src, children, pref, blank }) => {
    return (
        <a
            href={src}
            target={blank ? '_blank' : '_self'}
            rel="noreferrer"
            className={`button button_bordered button_${pref}`}
        >
            {children}
        </a>
    );
};

DefaultButtonLink.propTypes = propTypes;
DefaultButtonLink.defaultProps = defaultProps;

export default withTagDefaultProps(DefaultButtonLink);
