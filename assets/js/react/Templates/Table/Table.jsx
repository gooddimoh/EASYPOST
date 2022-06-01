import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import TableHeadColumn from './TableHeadColumn';
import { TableBody } from './TableBody';

const propTypes = {
    columns: PropTypes.arrayOf(PropTypes.any).isRequired,
    items: PropTypes.arrayOf(PropTypes.any).isRequired,
    buttons: PropTypes.arrayOf(PropTypes.node),
    pref: PropTypes.string.isRequired,
    onSortClick: PropTypes.func.isRequired,
    onFilterChange: PropTypes.func.isRequired,
    request: PropTypes.objectOf(PropTypes.any).isRequired,
    config: PropTypes.shape({
        isVertical: PropTypes.bool,
        activeItem: PropTypes.string,
    }),
};

const defaultProps = {
    config: {},
    buttons: [],
};

const Table = ({ columns, items, buttons, onSortClick, onFilterChange, request, config, pref }) => (
    <table className={`main-table main-table_${pref} ${config.isVertical ? 'main-table_vertical' : ''}`}>
        <thead className={`main-table__head main-table__head_${pref}`}>
            <tr className={`main-table__row main-table__row_${pref}`}>
                {columns.map((column, k) => (
                    <TableHeadColumn
                        key={`${column}-${k}`}
                        column={column}
                        sort={request.sort}
                        filter={request.filter}
                        onSortClick={onSortClick}
                        onFilterChange={onFilterChange}
                    />
                ))}
            </tr>
        </thead>
        <TableBody buttons={buttons} columns={columns} items={items} config={config} />
    </table>
);

Table.propTypes = propTypes;
Table.defaultProps = defaultProps;

export default withTagDefaultProps(Table);
