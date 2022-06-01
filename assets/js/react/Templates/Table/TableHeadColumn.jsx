import React from 'react';
import {pathOr} from "ramda";
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { TableHeadTitle, TableHeadFilter } from './TableHead';

const propTypes = {
    column: PropTypes.string.isRequired,
    onSortClick: PropTypes.func.isRequired,
    onFilterChange: PropTypes.func.isRequired,
    pref: PropTypes.string.isRequired,
    sort: PropTypes.objectOf(PropTypes.any).isRequired,
    filter: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        getTableLabel: PropTypes.func.isRequired,
        getFilter: PropTypes.func.isRequired,
    }).isRequired,
};

const TableHeadColumn = ({ column, filter, sort, onSortClick, onFilterChange, pref, t, service:{ getTableLabel, getFilter } }) => {
    return (
        <>
            {column === '-1' ? (
                <th className={`main-table__col main-table__col_empty main-table__col_${pref}`}>
                    <div className={`main-table__empty  main-table__empty_${pref}`} />
                </th>
            ) : (
                <th className={`main-table__col main-table__col_${pref}`}>
                    <div className={`sort sort_${pref}`}>
                        <TableHeadTitle column={column} sort={sort} onSortClick={() => onSortClick(column)}>
                            {t(getTableLabel(column))}
                        </TableHeadTitle>
                        <TableHeadFilter>
                            {getFilter(column, pathOr('', [column], filter), onFilterChange, {
                                filter,
                                sort,
                            })}
                        </TableHeadFilter>
                    </div>
                </th>
            )}
        </>
    );
};

TableHeadColumn.propTypes = propTypes;

export default withTagDefaultProps(TableHeadColumn);
