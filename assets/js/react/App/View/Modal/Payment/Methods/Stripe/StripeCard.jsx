import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps, StripeContext } from 'Hoc/Template';
import { FormRow, FormCol, Label, FormRowCenter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { useStripe, useElements, CardElement } from '@stripe/react-stripe-js';
import { ErrorNotification } from 'Widgets/NotificationWrap';
import { Img } from 'Templates/Img';
import { Spinloader } from 'Templates/Preloader';

const propTypes = {
    name: PropTypes.string.isRequired,
    label: PropTypes.string.isRequired,
    onSubmit: PropTypes.func.isRequired,
};

const StripeCard = ({ name, label, onSubmit, t }) => {
    const [localDisabled, setLocalDisabled] = useState(false);
    const [processing, setProcessing] = useState(false);
    const stripe = useStripe();
    const elements = useElements();
    const onChange = (event) => setLocalDisabled(event.complete);

    const handleSubmit = async (clientSecret) => {
        setLocalDisabled(false);
        setProcessing(true);
        const result = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: elements.getElement(CardElement),
            },
        });
        if (result.error) {
            ErrorNotification({ title: 'Something went wrong!', text: result.error.message });
            setProcessing(false);
            setLocalDisabled(true);
            return null;
        }
        setProcessing(false);
        setLocalDisabled(true);
        return result.paymentIntent;
    };

    const _onSubmit = () => onSubmit(handleSubmit);

    return (
        <>
            <FormRow>
                <FormCol>
                    <Label name={name} label={label} />
                    <div className="input input_stripe">
                        <CardElement onChange={onChange} />
                    </div>
                </FormCol>
            </FormRow>
            <FormRowCenter>
                <BorderButton disabled={!localDisabled} name="pay" onClick={_onSubmit}>
                    <Spinloader show={processing} />
                    <Img img="icon_lock" alt="lock" />
                    <span>{t('Pay With Card by Stripe')}</span>
                </BorderButton>
            </FormRowCenter>
        </>
    );
};

StripeCard.propTypes = propTypes;

export default compose(withTagDefaultProps, StripeContext)(StripeCard);
