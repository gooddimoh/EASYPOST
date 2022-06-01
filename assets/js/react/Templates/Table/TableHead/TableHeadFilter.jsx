import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    children: PropTypes.node.isRequired,
    pref: PropTypes.string.isRequired,
};

const TableHeadFilter = ({ children, pref }) => {
    return <div className={`sort__block sort__block_${pref}`}>{children}</div>;
};

TableHeadFilter.propTypes = propTypes;

export default withTagDefaultProps(TableHeadFilter);
