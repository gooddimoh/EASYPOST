import React, { useMemo } from 'react';
import { compose, not, isEmpty } from 'ramda';
import PropTypes from 'prop-types';
import { FetchItemProps } from 'Hoc/Template';
import { Pagination } from 'Templates/Pagination';
import TableBody from './TableBody';

const propTypes = {
    pagination: PropTypes.objectOf(PropTypes.any).isRequired,
    request: PropTypes.objectOf(PropTypes.any).isRequired,
    onPerPageChange: PropTypes.func.isRequired,
    onPageClick: PropTypes.func.isRequired,
    onFilterChange: PropTypes.func.isRequired,
    onSubmit: PropTypes.func.isRequired,
    onSortClick: PropTypes.func.isRequired,
    buttons: PropTypes.arrayOf(PropTypes.node),
    columns: PropTypes.arrayOf(PropTypes.string),
    items: PropTypes.arrayOf(PropTypes.object),
    config: PropTypes.shape({
        isVertical: PropTypes.bool,
        activeItem: PropTypes.string,
    }),
};

const defaultProps = {
    config: {},
    buttons: [],
    items: [],
    columns: [],
};

const TableWidget = ({
    items,
    columns,
    request,
    pagination,
    pref,
    buttons,
    onFilterChange,
    onSubmit,
    onSortClick,
    onPerPageChange,
    onPageClick,
    config,
}) => {
    const _columns = useMemo(() => (!buttons.length ? columns : [...columns, '-1']), [columns]);
    const _buttons = useMemo(() => buttons, []);
    const _config = useMemo(() => config, []);

    return (
        <div className={`table-wrap table-wrap_${pref}`}>
            <div className={`table-wrap__block table-wrap__block_${pref}`}>
                <form className={`form form_${pref}`} onSubmit={onSubmit}>
                    <TableBody
                        items={items}
                        columns={_columns}
                        request={request}
                        buttons={_buttons}
                        onSortClick={onSortClick}
                        onFilterChange={onFilterChange}
                        config={_config}
                    />
                    <button type="submit" className="visuallyhidden" />
                </form>
            </div>
            {not(isEmpty(pagination)) && (
                <Pagination pagination={pagination} onPageClick={onPageClick} onPerPageChange={onPerPageChange} />
            )}
        </div>
    );
};

TableWidget.propTypes = propTypes;
TableWidget.defaultProps = defaultProps;

export default compose(FetchItemProps)(TableWidget);
