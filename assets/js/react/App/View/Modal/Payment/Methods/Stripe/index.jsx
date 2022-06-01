import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { paymentType } from 'Services/Enums';
import { ErrorNotification } from 'Widgets/NotificationWrap';
import { FormRow, FormDesc, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import StripeCard from './StripeCard';

const propTypes = {
    onSubmit: PropTypes.func.isRequired,
    method: PropTypes.string.isRequired,
    amount: PropTypes.string.isRequired,
    agree: PropTypes.arrayOf(PropTypes.string).isRequired,
    onChange: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        createPaymentIntent: PropTypes.func.isRequired,
        addPaymentStripe: PropTypes.func.isRequired,
    }).isRequired,
};

const Stripe = ({ onSubmit, method, amount, agree, onChange, validateForm, errors, service }) => {
    const { createPaymentIntent, addPaymentStripe } = service;

    const validateOnSubmit = (callback) => {
        validateForm({ method, amount, agree }, async () => {
            const { client_secret } = await createPaymentIntent({ amount });
            const { amount: balance, id } = await callback(client_secret);
            const result = await addPaymentStripe({ payment_intent_id: id, balance, method: paymentType.card });
            if (result.error) {
                ErrorNotification({ title: 'Something went wrong!', text: result.error.message });
                return null;
            }
            await onSubmit();
            return result;
        });
    };

    return (
        <>
            <FormRow>
                <WrapInput name="agree" errors={errors.agree} reverse>
                    <Input
                        type="checkbox"
                        value={agree}
                        inputProps={{
                            options: [
                                {
                                    value: 'agree',
                                    label: "I've read and agree to TOS, Privacy Policy, Refund Policy and allow to charge my credit card / account Securely processed by Stripe.",
                                },
                            ],
                        }}
                        onChange={onChange('agree')}
                    />
                </WrapInput>
            </FormRow>
            <FormRow>
                <FormDesc title="We do not store any of your sensitive credit card information on our servers." />
            </FormRow>
            <StripeCard name="stripe" label="Pay with Credit Card by Stripe" onSubmit={validateOnSubmit} />
        </>
    );
};

Stripe.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        method: getStoreItem(state, ['payment', 'form', 'method'], ''),
        amount: getStoreItem(state, ['payment', 'form', 'amount'], ''),
        agree: getStoreItem(state, ['payment', 'form', 'agree'], []),
        errors: getStoreItem(state, ['payment', 'formErrors'], {}),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Stripe);
