import React from 'react';
import PropTypes from 'prop-types';
import { Table } from 'Templates/Table';

const TableBody = ({ items, columns, buttons, onSortClick, request, onFilterChange, config }) => {
    return (
        <Table
            buttons={buttons}
            columns={columns}
            items={items}
            request={request}
            onSortClick={onSortClick}
            onFilterChange={onFilterChange}
            config={config}
        />
    );
};

TableBody.propTypes = {
    columns: PropTypes.arrayOf(PropTypes.string).isRequired,
    items: PropTypes.arrayOf(PropTypes.object).isRequired,
    buttons: PropTypes.arrayOf(PropTypes.node),
    request: PropTypes.objectOf(PropTypes.any).isRequired,
    onSortClick: PropTypes.func.isRequired,
    onFilterChange: PropTypes.func.isRequired,
    config: PropTypes.shape({
        isVertical: PropTypes.bool,
        activeItem: PropTypes.string,
    }),
};

TableBody.defaultProps = {
    buttons: [],
    config: {},
};

export default TableBody;
