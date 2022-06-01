import React, { useEffect, useState } from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { formatIntToCurrency } from 'Services';
import { showPaymentModal } from 'Widgets/Modal';
import { SimpleButton } from 'Templates/Button';
import { Spinloader } from 'Templates/Preloader';

const propTypes = {
    balance: PropTypes.number.isRequired,
    requestGetBalance: PropTypes.func.isRequired,
};

const Balance = ({ balance, requestGetBalance, t }) => {
    const [isFetching, setIsFetching] = useState(true);

    const requestBalance = async () => {
        setIsFetching(true);
        await requestGetBalance();
        setIsFetching(false);
    };

    useEffect(() => requestBalance(), []);

    return (
        <div className="balance">
            {(isFetching && <Spinloader show />) || (
                <>
                    <div className="balance__total">{`${t('Balance')}: ${formatIntToCurrency(balance)}`}</div>
                    <SimpleButton
                        name="add-funds"
                        onClick={() => showPaymentModal()}
                        iconLeft="icon_funds"
                        title="Add Funds"
                    />
                </>
            )}
        </div>
    );
};

Balance.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        balance: getStoreItem(state, 'balance', 0),
    };
};

const mapDispatchToProps = ({ service: { getModalActionStore } }) => {
    return {
        requestGetBalance: getModalActionStore('requestGetBalance'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Balance);
