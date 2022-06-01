import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import TableBodyButtons from './TableBodyButtons';

const propTypes = {
    column: PropTypes.string.isRequired,
    buttons: PropTypes.arrayOf(PropTypes.node),
    item: PropTypes.objectOf(PropTypes.any),
    service: PropTypes.shape({
        getViewItem: PropTypes.func.isRequired,
    }).isRequired,
    pref: PropTypes.string.isRequired,
};

const defaultProps = {
    buttons: [],
    item: {},
};

const TableBodyColumn = ({ column, item, buttons, service: { getViewItem }, pref }) => {
    return (
        <>
            {column === '-1' ? (
                <td className={`main-table__col main-table__col--sticky main-table__col_${pref}`}>
                    <TableBodyButtons item={item} buttons={buttons} />
                </td>
            ) : (
                <td className={`main-table__col main-table__col_${pref}`}>
                    <div className={`main-table__info main-table__info_${pref}`}>{getViewItem(column, item)}</div>
                </td>
            )}
        </>
    );
};

TableBodyColumn.propTypes = propTypes;
TableBodyColumn.defaultProps = defaultProps;

export default withTagDefaultProps(TableBodyColumn);
