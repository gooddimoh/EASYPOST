import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { TableWidget } from 'Widgets/Table';

const propTypes = {
    buttons: PropTypes.arrayOf(PropTypes.node),
};

const defaultProps = {
    buttons: [],
};

const TableView = ({ buttons }) => {
    return <TableWidget buttons={buttons} />;
};

TableView.propTypes = propTypes;
TableView.defaultProps = defaultProps;

export default withTagDefaultProps(TableView);
