import React from 'react';
import PropTypes from 'prop-types';
import {formatIntToCurrency} from 'Services';

const propTypes = {
    pref: PropTypes.string.isRequired,
    balance: PropTypes.string.isRequired,
};

const BalanceItem = ({ pref, balance }) => {
    const className = [
        'main-table__text',
        `main-table__text_${pref}`,
        `main-table__text-${+balance > 0 ? 'green' : 'red'}`,
    ];

    return (
        <span className={className.join(' ')}>
            {balance > 0 && '+'}
            {formatIntToCurrency(balance)}
        </span>
    );
};

BalanceItem.propsTypes = propTypes;

export default BalanceItem;
