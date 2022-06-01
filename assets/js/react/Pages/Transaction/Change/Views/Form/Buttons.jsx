import React from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { url as _url } from 'Services';
import { FormCol } from 'Templates/Form';
import { ButtonsWrap, BorderButton } from 'Templates/Button';
import { NotificationWrap } from 'Widgets/NotificationWrap';

const propTypes = {
    transaction: PropTypes.shape({
        balance: PropTypes.string.isRequired,
        method: PropTypes.string.isRequired,
        company: PropTypes.string.isRequired,
        description: PropTypes.string.isRequired,
    }).isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
    submitForm: PropTypes.func.isRequired,
    onResetForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    edit: PropTypes.bool,
};

const defaultProps = {
    edit: false,
};

const Buttons = ({ transaction, t, submitForm, onResetForm, validateForm, edit, service: { url } }) => {
    const onSubmit = () => {
        validateForm(transaction, async () => {
            await submitForm(transaction);
            NotificationWrap({ title: 'Success!', text: 'Transaction saved' });
            _url.redirect(`/${url}`);
        });
    };

    const onSubmitAnother = async () => {
        validateForm(transaction, async () => {
            await submitForm(transaction);
            NotificationWrap({ title: 'Success!', text: 'Transaction saved' });
            onResetForm();
        });
    };

    return (
        <FormCol>
            <ButtonsWrap>
                {!edit && (
                    <BorderButton onClick={onSubmitAnother} name="save-add-another">
                        {t('Save & Add Another')}
                    </BorderButton>
                )}
                <BorderButton onClick={onSubmit} name="save">
                    {t('Save')}
                </BorderButton>
            </ButtonsWrap>
        </FormCol>
    );
};

Buttons.propTypes = propTypes;
Buttons.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        transaction: {
            balance: getStoreItem(state, 'balance', ''),
            method: getStoreItem(state, 'method', ''),
            company: getStoreItem(state, 'company', ''),
            description: getStoreItem(state, 'description', ''),
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
