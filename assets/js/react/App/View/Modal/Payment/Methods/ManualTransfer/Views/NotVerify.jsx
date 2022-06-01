import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, FormCol, WrapInput, FormDesc, FormError } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { BorderButton } from 'Templates/Button';
import { Img } from 'Templates/Img';

const propTypes = {
    form: PropTypes.shape({
        amountFirst: PropTypes.string.isRequired,
        amountSecond: PropTypes.string.isRequired,
        method: PropTypes.string.isRequired,
    }).isRequired,
    validateForm: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired,
    initPaymentModal: PropTypes.func.isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        verifyCustomer: PropTypes.func.isRequired,
        initialStates: PropTypes.func.isRequired,
        checkVerifyView: PropTypes.func.isRequired,
        formDataManualVerification: PropTypes.func.isRequired,
    }).isRequired,
};

const NotVerify = ({ form, errors, validateForm, onChange, initPaymentModal, service, t }) => {
    const { verifyCustomer, initialStates, checkVerifyView, formDataManualVerification } = service;
    const { amountFirst, amountSecond, method } = form;

    const onSubmit = async () => {
        validateForm(form, async () => {
            const { has_customer, verified } = await verifyCustomer(formDataManualVerification(form));
            initPaymentModal({
                ...initialStates(method),
                accountView: checkVerifyView(has_customer, verified),
                showAmount: true,
            });
        });
    };

    return (
        <>
            <FormRow>
                <FormDesc title="Stripe automatically sends two small deposits for this purpose. These deposits take 1-2 business days to appear on the customer’s online statement." />
            </FormRow>
            <FormRow>
                <FormError title="When accepting these amounts, be aware that the limit is 3 failed verification attempts. If this limit is exceeded, the bank account can’t be verified." />
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="amountFirst" label="Amount first" errors={errors.amountFirst} required>
                        <Input value={amountFirst} onChange={onChange('amountFirst')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="amountSecond" label="Amount second" errors={errors.amountSecond} required>
                        <Input value={amountSecond} onChange={onChange('amountSecond')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <BorderButton fullWidth name="pay" onClick={onSubmit}>
                    <Img img="icon_lock" alt="lock" />
                    {t('Verify your account')}
                </BorderButton>
            </FormRow>
        </>
    );
};

NotVerify.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            amountFirst: getStoreItem(state, ['payment', 'form', 'amountFirst'], ''),
            amountSecond: getStoreItem(state, ['payment', 'form', 'amountSecond'], ''),
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

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(NotVerify);
