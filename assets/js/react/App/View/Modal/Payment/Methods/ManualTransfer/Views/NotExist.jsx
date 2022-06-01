import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps, StripeContext } from 'Hoc/Template';
import { ErrorNotification } from 'Widgets/NotificationWrap';
import { FormRow, WrapInput, FormDesc } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { BorderButton } from 'Templates/Button';
import { Spinloader } from 'Templates/Preloader';
import { Img } from 'Templates/Img';
import { useStripe } from '@stripe/react-stripe-js';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    initPaymentModal: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    form: PropTypes.shape({
        routingNumber: PropTypes.string.isRequired,
        accountNumber: PropTypes.string.isRequired,
        holderName: PropTypes.string.isRequired,
        method: PropTypes.string.isRequired,
    }).isRequired,
    service: PropTypes.shape({
        createCustomer: PropTypes.func.isRequired,
        initialStates: PropTypes.func.isRequired,
        checkVerifyView: PropTypes.func.isRequired,
        formDataManualAnonymous: PropTypes.func.isRequired,
    }).isRequired,
};

const NotExist = ({ form, errors, onChange, initPaymentModal, service, validateForm, t }) => {
    const [processing, setProcessing] = useState(false);
    const stripe = useStripe();
    const { createCustomer, initialStates, checkVerifyView, formDataManualAnonymous } = service;

    const { method, routingNumber, accountNumber, holderName } = form;

    const onSubmit = async () => {
        validateForm(form, async () => {
            setProcessing(true);
            const result = await stripe.createToken('bank_account', formDataManualAnonymous(form));
            setProcessing(false);
            if (result.error) {
                ErrorNotification({ title: 'Something went wrong!', text: result.error.message });
                return;
            }
            const { has_customer, verified } = await createCustomer({ token_id: result.token.id });
            initPaymentModal({ ...initialStates(method), accountView: checkVerifyView(has_customer, verified) });
        });
    };

    return (
        <>
            <FormRow>
                <FormDesc title="You need to link your bank account to PostalBridge to make payment" />
            </FormRow>
            <FormRow>
                <WrapInput name="holderName" label="Holder Name" errors={errors.holderName} required>
                    <Input value={holderName} onChange={onChange('holderName')} />
                </WrapInput>
            </FormRow>
            <FormRow>
                <WrapInput name="routingNumber" label="Routing Number" errors={errors.routingNumber} required>
                    <Input value={routingNumber} onChange={onChange('routingNumber')} />
                </WrapInput>
            </FormRow>
            <FormRow>
                <WrapInput name="accountNumber" label="Account Number" errors={errors.accountNumber} required>
                    <Input value={accountNumber} onChange={onChange('accountNumber')} />
                </WrapInput>
            </FormRow>
            <FormRow>
                <BorderButton fullWidth name="pay" disabled={processing} onClick={onSubmit}>
                    <Spinloader show={processing} />
                    <Img img="icon_lock" alt="lock" />
                    {t('Link Bank Account to PostalBridge')}
                </BorderButton>
            </FormRow>
        </>
    );
};

NotExist.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            holderName: getStoreItem(state, ['payment', 'form', 'holderName'], ''),
            routingNumber: getStoreItem(state, ['payment', 'form', 'routingNumber'], ''),
            accountNumber: getStoreItem(state, ['payment', 'form', 'accountNumber'], ''),
            method: getStoreItem(state, ['payment', 'form', 'method'], ''),
        },
        errors: getStoreItem(state, ['payment', 'formErrors'], {}),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        initPaymentModal: getActionStore('initPaymentModal'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps), StripeContext)(NotExist);
