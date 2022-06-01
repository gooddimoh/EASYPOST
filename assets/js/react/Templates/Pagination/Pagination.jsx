import React from 'react';
import {compose} from 'redux';
import PropTypes from 'prop-types';
import {withTagDefaultProps} from 'Hoc/Template';
import {rowsPerPageOptions} from 'Services/Enums';
import {ArrowButton} from 'Templates/Pagination';
import {Input} from 'Templates/Input';

const getStringPageItemsPortion = (perPage, page, total, pages) => {
    if (!pages) return '0';
    const start = (page - 1) * perPage + 1;
    const end = Math.min(page * perPage, total);
    return `${start} - ${end}`;
};

const propTypes = {
    t: PropTypes.func.isRequired,
    pref: PropTypes.string.isRequired,
    pagination: PropTypes.objectOf(PropTypes.any).isRequired,
    onPageClick: PropTypes.func.isRequired,
    onPerPageChange: PropTypes.func.isRequired,
};

const inputProps = { options: rowsPerPageOptions };

const Pagination = ({ t, pref, pagination, onPageClick, onPerPageChange }) => {
    const { count, total, per_page, page, pages } = pagination;

    const showPrevPageArrow = page !== 1 && !!count;
    const showNextPageArrow = page !== pages && !!count;
    const itemsPortion = getStringPageItemsPortion(per_page, page, total, pages);
    const _onPageClick = (i) => () => onPageClick(page + i);

    return (
        <div className={`main-pagination main-pagination_${pref}`}>
            <div className={`main-pagination__page-option-container main-pagination__page-option-container_${pref}`}>
                <div className="main-pagination__text">{t('Rows per page')}</div>
                <div className="main-pagination__block">
                    <Input
                        type="select"
                        name="size"
                        inputProps={inputProps}
                        value={`${per_page}`}
                        onChange={onPerPageChange}
                    />
                </div>
            </div>
            <div className={`main-pagination__arrow-container main-pagination__arrow-container_${pref}`}>
                <div className={`main-pagination__page-items-count main-pagination__page-items-count_${pref}`}>
                    {`${itemsPortion} ${t('of')} ${total}`}
                </div>
                <div className={`main-pagination__page-items-btn main-pagination__page-items-btn_${pref}`}>
                    {showPrevPageArrow && <ArrowButton onClick={_onPageClick(-1)} side="left"/>}
                    {showNextPageArrow && <ArrowButton onClick={_onPageClick(1)} side="right"/>}
                </div>
            </div>
        </div>
    );
};

Pagination.propTypes = propTypes;

export default compose(
    withTagDefaultProps
)(Pagination);
