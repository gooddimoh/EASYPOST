import React, { useEffect, useMemo } from 'react';
import PropTypes from 'prop-types';
import { compose, multiply } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import useContainer from 'Hoc/UseEffect/useContainer';
import { FormRow, FormDesc } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { Img } from 'Templates/Img';
import PlaidLink from './PlaidLink';

const propTypes = {
    onSubmit: PropTypes.func.isRequired,
    amount: PropTypes.string.isRequired,
    service: PropTypes.shape({
        chargeAutoTransfer: PropTypes.func.isRequired,
        createNewCharge: PropTypes.func.isRequired,
    }).isRequired,
    linkToken: PropTypes.string,
};

const defaultProps = {
    linkToken: null,
};

const AutoTransfer = ({ onSubmit, amount, linkToken, service, t }) => {
    const { chargeAutoTransfer, createNewCharge } = service;
    const submitCharge = async () => {
        const res = await chargeAutoTransfer({ amount });
        await onSubmit();
        return res;
    };
    const createCharge = async (public_token, account_id) => {
        const res = await createNewCharge({ public_token, account_id, amount: multiply(useContainer.get(), 100) });
        await onSubmit();
        return res;
    };

    useEffect(() => useContainer.set(amount), [amount]);

    const renderButton = useMemo(() => {
        if (linkToken) return <PlaidLink token={linkToken} success={createCharge} />;
        return (
            <BorderButton fullWidth name="pay" onClick={submitCharge}>
                <Img img="icon_lock" alt="lock" />
                {t('Pay With ACH Transfer by Stripe')}
            </BorderButton>
        );
    }, [amount]);

    return (
        <>
            <FormRow>
                <FormDesc title="PostalBridge accepting ACH payments direct from bank accounts alongside credit cards." />
            </FormRow>
            <FormRow>{renderButton}</FormRow>
        </>
    );
};

AutoTransfer.propTypes = propTypes;
AutoTransfer.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        linkToken: getStoreItem(state, ['payment', 'linkToken'], null),
        amount: getStoreItem(state, ['payment', 'form', 'amount'], ''),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, null))(AutoTransfer);
