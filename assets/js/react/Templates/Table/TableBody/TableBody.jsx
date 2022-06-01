import React, { memo } from 'react';
import { compose } from 'redux';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import TableBodyColumn from '../TableBodyColumn';

const propTypes = {
    items: PropTypes.arrayOf(PropTypes.object).isRequired,
    buttons: PropTypes.arrayOf(PropTypes.node).isRequired,
    columns: PropTypes.arrayOf(PropTypes.string).isRequired,
    pref: PropTypes.string.isRequired,
    config: PropTypes.shape({
        isVertical: PropTypes.bool,
        activeItem: PropTypes.string,
    }),
};

const defaultProps = {
    config: {
        activeItem: '',
    },
};

const TableBody = ({ pref, items, columns, buttons, config }) => {
    return (
        <tbody className={`main-table__body main-table__body_${pref}`}>
            {items.map((item) => (
                <tr
                    className={`main-table__row main-table__row_${pref} ${
                        item.id === config.activeItem ? 'active-row' : ''
                    }`}
                    key={item._id || item.id}
                >
                    {columns.map((key) => (
                        <TableBodyColumn buttons={buttons} key={`${item._id}-${key}`} column={key} item={item} />
                    ))}
                </tr>
            ))}
        </tbody>
    );
};

TableBody.propTypes = propTypes;
TableBody.defaultProps = defaultProps;

export default compose(memo, withTagDefaultProps)(TableBody);
