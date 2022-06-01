import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    title: PropTypes.string.isRequired,
    pref: PropTypes.string.isRequired
};

const DefaultSpan = ({ pref, title }) => (
    <span title={title} className={`main-table__text main-table__text_${pref}`}>
        {title}
    </span>
);

DefaultSpan.propsTypes = propTypes;

export default withTagDefaultProps(DefaultSpan);