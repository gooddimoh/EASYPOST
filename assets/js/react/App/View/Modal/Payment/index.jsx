import React, { useEffect, Suspense, useCallback } from 'react';
import PropTypes from 'prop-types';
import { compose, curry, isEmpty, equals } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { schemaCall } from 'Services';
import { ServiceProvider } from 'Services/Context';
import { paymentMethods, balanceAmount, paymentType, accountVerifyType } from 'Services/Enums';
import { close, info } from 'Widgets/Modal';
import { FormBody, FormRow, WrapInput, Form } from 'Templates/Form';
import { Input } from 'Templates/Input';
import service from './Service';

const {
    renderMethodFields,
    initialStates,
    succesfullyText,
    getStoreItem,
    getActionStore,
    createLinkToken,
    isCustomerLink,
    checkVerifyView,
} = service;

const propTypes = {
    kModal: PropTypes.string.isRequired,
    amountLabel: PropTypes.string.isRequired,
    method: PropTypes.string.isRequired,
    amount: PropTypes.string.isRequired,
    initPaymentModal: PropTypes.func.isRequired,
    requestGetBalance: PropTypes.func.isRequired,
    _onChange: PropTypes.func.isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    onSuccess: PropTypes.func,
    showAmount: PropTypes.bool.isRequired,
};

const defaultProps = {
    onSuccess: () => {},
};

const Payment = ({
    kModal,
    amountLabel,
    method,
    amount,
    initPaymentModal,
    requestGetBalance,
    _onChange,
    errors,
    onSuccess,
    showAmount,
}) => {
    const onChange = curry((k, v) => _onChange(['payment', 'form', k], v));

    const onChangeMethod = useCallback(
        schemaCall({
            [paymentType.autoTransfer]: async (_, val) => {
                const { link_token } = await createLinkToken({});
                initPaymentModal({
                    ...initialStates(val),
                    linkToken: link_token,
                });
            },
            [paymentType.manualTransfer]: async (_, val) => {
                const { has_customer, verified } = await isCustomerLink({});
                const accountView = checkVerifyView(has_customer, verified);
                initPaymentModal({
                    ...initialStates(val),
                    accountView,
                    showAmount: equals(accountView, accountVerifyType.verify),
                });
            },
            _: (_, val) => initPaymentModal(initialStates(val)),
        }),
        [],
    );

    useEffect(() => {
        if (isEmpty(method)) {
            initPaymentModal(initialStates(paymentType.card));
        }
        return () => initPaymentModal(initialStates(paymentType.card));
    }, []);

    const onSubmit = async () => {
        await requestGetBalance();
        close(kModal);
        info({ text: succesfullyText(method) }, () => onSuccess(method));
    };

    return (
        <ServiceProvider value={service}>
            <Form>
                <FormBody>
                    <FormRow>
                        <WrapInput name="method" label="Choose your payment method" errors={errors.method} required>
                            <Input
                                value={method}
                                type="select"
                                inputProps={{ options: paymentMethods.getListValues([paymentType.admin]) }}
                                onChange={onChangeMethod}
                            />
                        </WrapInput>
                    </FormRow>
                    {showAmount && (
                        <FormRow>
                            <WrapInput name="amount" label={amountLabel} errors={errors.amount} required>
                                <Input
                                    value={amount}
                                    type="select"
                                    inputProps={{ options: balanceAmount }}
                                    onChange={onChange('amount')}
                                />
                            </WrapInput>
                        </FormRow>
                    )}

                    {method && <Suspense fallback={<div />}>{renderMethodFields(method)(onSubmit, onChange)}</Suspense>}
                </FormBody>
            </Form>
        </ServiceProvider>
    );
};

Payment.propTypes = propTypes;
Payment.defaultProps = defaultProps;

const mapStateToProps = (state) => {
    return {
        amountLabel: getStoreItem(state, ['payment', 'amountLabel'], ''),
        method: getStoreItem(state, ['payment', 'form', 'method'], ''),
        amount: getStoreItem(state, ['payment', 'form', 'amount'], '50'),
        errors: getStoreItem(state, ['payment', 'formErrors'], {}),
        showAmount: getStoreItem(state, ['payment', 'showAmount'], true),
    };
};

const mapDispatchToProps = () => {
    return {
        initPaymentModal: getActionStore('initPaymentModal'),
        _onChange: getActionStore('onChangePayment'),
        requestGetBalance: getActionStore('requestGetBalance'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Payment);
