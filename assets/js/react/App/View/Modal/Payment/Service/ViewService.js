import React, { lazy } from 'react';
import { cond, T } from 'ramda';
import { schema } from 'Services';
import { paymentType, accountVerifyType } from 'Services/Enums';

const Stripe = lazy(() => import('../Methods/Stripe'));
const AutoTransfer = lazy(() => import('../Methods/AutoTransfer'));
const ManualTransfer = lazy(() => import('../Methods/ManualTransfer'));
const Paypal = lazy(() => import('../Methods/Paypal'));
const Bitcoin = lazy(() => import('../Methods/Bitcoin'));

export const renderMethodFields = schema({
    [paymentType.card]: (onSubmit, onChange) => <Stripe onSubmit={onSubmit} onChange={onChange} />,
    [paymentType.autoTransfer]: (onSubmit) => <AutoTransfer onSubmit={onSubmit} />,
    [paymentType.manualTransfer]: (onSubmit, onChange) => <ManualTransfer onSubmit={onSubmit} onChange={onChange} />,
    [paymentType.paypal]: (onSubmit) => <Paypal onSubmit={onSubmit} />,
    [paymentType.bitcoin]: () => <Bitcoin />,
});

export const initialStates = schema({
    [paymentType.card]: {
        amountLabel: 'Pay with Credit Card by Stripe',
        form: {
            method: '1',
            amount: '50',
            agree: [],
        },
        formValidate: false,
        formErrors: {},
    },
    [paymentType.autoTransfer]: {
        amountLabel: 'Pay with ACH Transfer Online Now',
        form: {
            method: '2',
            amount: '50',
        },
        linkToken: null,
        formValidate: true,
        formErrors: {},
    },
    [paymentType.manualTransfer]: {
        amountLabel: 'Pay with ACH Transfer Online Now',
        form: {
            method: '3',
            amount: '50',
            holderName: '',
            routingNumber: '',
            accountNumber: '',
            amountFirst: '',
            amountSecond: '',
        },
        formValidate: false,
        formErrors: {},
        showAmount: false,
        accountView: '',
    },
    [paymentType.paypal]: {
        amountLabel: 'Pay with PayPal Instant',
        form: {
            method: '4',
            amount: '50',
        },
        formValidate: true,
        formErrors: {},
    },
    [paymentType.bitcoin]: {
        amountLabel: 'Pay with Bitcoin',
        form: {
            method: '5',
            amount: '50',
        },
        formValidate: true,
        formErrors: {},
    },
});

export const checkVerifyView = (has_customer, verified) => {
    return cond([
        [() => !has_customer, () => accountVerifyType.notExist],
        [() => has_customer && !verified, () => accountVerifyType.notVerify],
        [T, () => accountVerifyType.verify],
    ])(has_customer, verified);
};

export const succesfullyText = schema({
    [paymentType.autoTransfer]: 'The payment was successful. Funds will be credited within 5 working days.',
    [paymentType.manualTransfer]: 'The payment was successful. Funds will be credited within 5 working days.',
    _: 'The payment was successful.',
});
