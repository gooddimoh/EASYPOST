import React from 'react';
import { compose, isEmpty } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormBody, FormRow, FormCol, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { BorderButton } from 'Templates/Button';
import { NotificationWrap } from 'Widgets/NotificationWrap';

const propTypes = {
    full_name: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    email: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    message: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    check: PropTypes.arrayOf(PropTypes.string).isRequired,
    onChange: PropTypes.func.isRequired,
    submitForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    onResetForm: PropTypes.func.isRequired,
};

const Block = ({ full_name, email, message, check, onChange, submitForm, validateForm, onResetForm, t }) => {
    const disabled = isEmpty(check);

    const submitRequest = async (cb, form) => {
        const res = await submitForm(form);
        if (res) {
            cb();
        }
    };

    const onSubmit = () => {
        const form = {
            full_name: full_name.value,
            email: email.value,
            message: message.value,
            check,
        };

        validateForm(form, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'Massage send' });
                onResetForm();
            }, form);
        });
    };
    return (
        <FormBody>
            <FormRow>
                <FormCol>
                    <WrapInput name="name" label="Enter Your First & Last Name" errors={full_name.errors} required>
                        <Input type="name" placeholder="Enter Your First & Last Name" value={full_name.value} onChange={onChange('full_name')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="email" label="Enter Your Email" errors={email.errors} required>
                        <Input type="email" placeholder="Enter Your Email" value={email.value} onChange={onChange('email')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="message" label="Message" errors={message.errors} required>
                        <Input type="textarea" value={message.value} onChange={onChange('message')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="check" required>
                        <Input
                            type="checkbox"
                            name="check"
                            value={check}
                            inputProps={{
                                options: [{ value: 'check', label: 'I agree to the processing of my data' }],
                            }}
                            onChange={onChange('check')}
                        />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <BorderButton onClick={onSubmit} name="send" disabled={disabled}>
                    {t('Send')}
                </BorderButton>
            </FormRow>
        </FormBody>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        full_name: {
            value: getStoreItem(state, 'full_name', ''),
            errors: getStoreItem(state, ['formErrors', 'full_name'], []),
        },
        email: {
            value: getStoreItem(state, 'email', ''),
            errors: getStoreItem(state, ['formErrors', 'email'], []),
        },
        message: {
            value: getStoreItem(state, 'message', ''),
            errors: getStoreItem(state, ['formErrors', 'message'], []),
        },
        check: getStoreItem(state, 'check', []),
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        onChange: getActionStore('onChange'),
        submitForm: getActionStore('submitFormAction'),
        onResetForm: getActionStore('onResetForm'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
