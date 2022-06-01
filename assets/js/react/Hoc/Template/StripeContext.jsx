import React from 'react';
import { loadStripe } from '@stripe/stripe-js';
import { Elements } from '@stripe/react-stripe-js';
import { getConfigKey } from 'Env';

const stripePromise = loadStripe(getConfigKey('stripe'));

const StripeContext = (Wrapped) => (props) =>
    (
        <Elements stripe={stripePromise}>
            {/* eslint-disable-next-line react/jsx-props-no-spreading */}
            <Wrapped {...props} />
        </Elements>
    );

export default StripeContext;
