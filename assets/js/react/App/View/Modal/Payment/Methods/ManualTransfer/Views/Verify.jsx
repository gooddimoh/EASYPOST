import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { Img } from 'Templates/Img';

const propTypes = {
    onSubmit: PropTypes.func.isRequired,
    amount: PropTypes.string.isRequired,
    service: PropTypes.shape({
        createManualCharge: PropTypes.func.isRequired,
    }).isRequired,
};

const Verify = ({ onSubmit, amount, service, t }) => {
    const { createManualCharge } = service;

    const _onSubmit = async () => {
        const res = await createManualCharge({ amount });
        await onSubmit();
        return res;
    };

    return (
        <FormRow>
            <BorderButton fullWidth name="pay" onClick={_onSubmit}>
                <Img img="icon_lock" alt="lock" />
                {t('Pay With ACH Transfer by Stripe')}
            </BorderButton>
        </FormRow>
    );
};

Verify.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        amount: getStoreItem(state, ['payment', 'form', 'amount'], ''),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps))(Verify);
