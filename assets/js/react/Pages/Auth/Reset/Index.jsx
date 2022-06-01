import React, { useState } from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { Input } from 'Templates/Input';
import { Img } from 'Templates/Img';
import { Form, FormRow, FormCol, WrapInput } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';

const propTypes = {
    error: PropTypes.string.isRequired,
    submitForm: PropTypes.func.isRequired,
    t: PropTypes.func.isRequired
};

const Index = ({ submitForm, error, pref, t }) => {
    const [state, setState] = useState({
        newPassword: '',
        confirmNewPassword: '',
    });

    const { newPassword, confirmNewPassword } = state;

    const onChange = (key, value) => setState({ ...state, [key]: value });

    const checkForm = () => {
        const minPasswordLength = 6;
        return !(
            newPassword.length >= minPasswordLength &&
            confirmNewPassword.length >= minPasswordLength &&
            newPassword === confirmNewPassword
        );
    };

    const onSubmitForm = () => submitForm({ password: newPassword });

    const componentForm = (
        <>
            <h1 className={`auth__title auth__title_${pref}`}>{t('Reset Your Password')}</h1>
            <Form onSubmit={onSubmitForm} className={`auth__form auth__form_${pref}`}>
                <FormRow>
                    <FormCol>
                        <WrapInput name="newPassword" label="New password" required>
                            <Input
                                type="password"
                                value={newPassword}
                                onChange={(value) => onChange('newPassword', value)}
                            />
                        </WrapInput>
                    </FormCol>
                </FormRow>
                <FormRow>
                    <FormCol>
                        <WrapInput name="confirmNewPassword" label="Confirm new password" required>
                            <Input
                                type="password"
                                value={confirmNewPassword}
                                onChange={(value) => onChange('confirmNewPassword', value)}
                            />
                        </WrapInput>
                    </FormCol>
                </FormRow>

                <FormRow>
                    <FormCol>
                        <BorderButton name="save" type="submit" disabled={ checkForm() }>
                            { t('Save password') }
                        </BorderButton>
                    </FormCol>
                </FormRow>
                <FormRow>
                    <FormCol>
                        <a href="/login" className={`auth__form-forgot-link auth__form-forgot-link_${pref}`}>
                            {t('Return to login')}
                        </a>
                    </FormCol>
                </FormRow>
            </Form>
        </>
    );

    return (
        <div className="main-wrap auth">
            <div className={`auth__wrap auth__wrap_${pref}`}>
                <div className={`auth__logo auth__logo_${pref}`}>
                    <a href="/" className={`auth__logo-link auth__logo-link_${pref}`}>
                         <Img img="logo-pic-big" alt="logo" />
                    </a>
                </div>
                <div className={`auth__content auth__content_${pref}`}>{error || componentForm}</div>
            </div>
        </div>
    );
};

Index.propTypes = propTypes;

const mapStateToProps = (state) => {
    return {
        error: state.pageState.error,
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        submitForm: getActionStore('submitFormAction'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Index);
