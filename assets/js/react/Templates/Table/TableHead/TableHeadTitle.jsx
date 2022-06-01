import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

const propTypes = {
    onSortClick: PropTypes.func.isRequired,
    sort: PropTypes.objectOf(PropTypes.any).isRequired,
    column: PropTypes.string,
    service: PropTypes.shape({
        isSortEnabled: PropTypes.func,
    }).isRequired,
};

const defaultProps = {
    column: '',
};

const TableHeadTitle = ({ children, pref, column, sort, service: { isSortEnabled }, onSortClick }) => {
    const _isSortEnabled = isSortEnabled || (() => true);
    const isEnabled = _isSortEnabled(column);
    const onClick = (e) => {
        e.preventDefault();
        onSortClick();
    };

    const link = () => (
        <a href="#" onClick={onClick} className={`sort__link sort__link_${pref}`}>
            {children}
            <div className={`sort__arrow sort__arrow_${pref}`}>
                <Img
                    img="sort-up"
                    alt="sort-up"
                    className={sort.column === column && sort.direction === 'asc' ? 'icon-active' : ''}
                />
                <Img
                    img="sort-down"
                    alt="sort-down"
                    className={sort.column === column && sort.direction === 'desc' ? 'icon-active' : ''}
                />
            </div>
        </a>
    );

    const fakeLink = () => <span className={`sort__link sort__link_${pref}`}>{children}</span>;

    return (isEnabled ? link : fakeLink)();
};

TableHeadTitle.propTypes = propTypes;
TableHeadTitle.defaultProps = defaultProps;

export default withTagDefaultProps(TableHeadTitle);
