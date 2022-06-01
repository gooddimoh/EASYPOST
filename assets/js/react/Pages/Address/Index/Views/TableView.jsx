import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { TableWidget } from 'Widgets/Table';

const propTypes = {
    buttons: PropTypes.arrayOf(PropTypes.node).isRequired,
};

const TableView = ({ buttons }) => {
    return <TableWidget buttons={buttons} />;
};

TableView.propTypes = propTypes;

export default withTagDefaultProps(TableView);
