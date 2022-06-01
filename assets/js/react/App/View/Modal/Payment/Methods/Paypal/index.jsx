import React from 'react';
import PropTypes from 'prop-types';
import { compose, multiply } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { paymentType } from 'Services/Enums';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, FormDesc } from 'Templates/Form';
import { PayPalScriptProvider, PayPalButtons } from '@paypal/react-paypal-js';

const propTypes = {
    onSubmit: PropTypes.func.isRequired,
    amount: PropTypes.string.isRequired,
    service: PropTypes.shape({
        addPaymentPaypal: PropTypes.func.isRequired,
    }).isRequired,
};

const Paypal = ({ onSubmit, amount, service }) => {
    const { addPaymentPaypal } = service;
    const createOrder = (_, actions) => {
        return actions.order.create({
            purchase_units: [
                {
                    amount: {
                        value: amount,
                        currency_code: 'USD',
                    },
                },
            ],
        });
    };

    const onApprove = async (data) => {
        const res = await addPaymentPaypal({
            order_id: data.orderID,
            balance: multiply(amount, 100),
            method: paymentType.paypal,
        });
        await onSubmit();
        return res;
    };

    return (
        <>
            <FormRow>
                <FormDesc
                    title={[
                        'You’ll be directed to PayPal.',
                        'Once complete, funds will be added to your PostalBridge balance.',
                    ]}
                />
            </FormRow>
            <FormRow>
                <PayPalScriptProvider
                    options={{
                        'client-id': 'Ad7FaJChDWXtVjBIn3d-IPkpfJcgj72VMu3FCCpxW9ACiRBXsCcovwLROU8LLk0eR7zp8qLpSi6vFaVN',
                    }}
                >
                    <PayPalButtons
                        key={amount}
                        createOrder={createOrder}
                        onApprove={onApprove}
                        style={{ layout: 'horizontal', tagline: false }}
                    />
                </PayPalScriptProvider>
            </FormRow>
        </>
    );
};

Paypal.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        amount: getStoreItem(state, ['payment', 'form', 'amount'], ''),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps))(Paypal);
