import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    href: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
    blank: PropTypes.bool,
};

const defaultProps = {
    blank: false,
};

const TableLink = ({ pref, href, title, blank }) => (
    <a
        href={href}
        target={blank ? '_blank' : '_self'}
        rel="noreferrer"
        title={title}
        className={`main-table__link main-table__link_${pref}`}
    >
        <span>{title}</span>
    </a>
);

TableLink.propTypes = propTypes;
TableLink.defaultProps = defaultProps;

export default withTagDefaultProps(TableLink);
