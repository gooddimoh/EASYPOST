import React from 'react';
import { compose, isEmpty } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { NotificationWrap } from 'Widgets/NotificationWrap';

const propTypes = {
    form: PropTypes.shape({
        full_name: PropTypes.string.isRequired,
        email: PropTypes.string.isRequired,
        message: PropTypes.string.isRequired,
        check: PropTypes.arrayOf(PropTypes.string).isRequired,
    }).isRequired,
    submitForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    onResetForm: PropTypes.func.isRequired,
};

const Buttons = ({ form, submitForm, validateForm, onResetForm, t }) => {
    const disabled = isEmpty(form.check);

    const submitRequest = async (cb) => {
        const res = await submitForm(form);
        if (res) {
            cb();
        }
    };

    const onSubmit = () => {
        validateForm(form, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'Massage send' });
                onResetForm();
            });
        });
    };

    return (
        <FormFooter>
            <BorderButton onClick={onSubmit} name="send" disabled={disabled}>
                {t('Send')}
            </BorderButton>
        </FormFooter>
    );
};

Buttons.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            full_name: getStoreItem(state, 'full_name', ''),
            email: getStoreItem(state, 'email', ''),
            message: getStoreItem(state, 'message', ''),
            check: getStoreItem(state, 'check', []),
        },
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        submitForm: getActionStore('submitFormAction'),
        onResetForm: getActionStore('onResetForm'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Buttons);
