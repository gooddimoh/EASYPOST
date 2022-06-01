import React, { useState } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Form, FormRow, FormError, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { RoundedButton } from 'Templates/Button';
import { ImageLink } from 'Templates/Link';

const propTypes = {
    csrf_token: PropTypes.string.isRequired,
    error: PropTypes.string.isRequired,
    submitForm: PropTypes.func.isRequired,
    service: PropTypes.shape({
        getStoreItem: PropTypes.func.isRequired,
        getActionStore: PropTypes.func.isRequired,
    }).isRequired,
};

const MainBlock = ({ csrf_token, submitForm, pref, error, t }) => {
    const [state, setState] = useState({ email: '', password: '' });
    const { email, password } = state;
    const onChange = (key, value) => setState({ ...state, [key]: value });

    const checkForm = () => {
        const minPasswordLength = 6;
        return !(email && password.length >= minPasswordLength);
    };

    const onSubmit = () => submitForm({ email, password, _csrf_token: csrf_token });

    if (error === 'Brute') window.location.href = '/auth/wait';

    return (
        <div className={`main-wrap main-wrap_${pref} auth`}>
            <div className={`auth__wrap auth__wrap_${pref}`}>
                <div className={`auth__content auth__content_${pref}`}>
                    <div className={`auth__box auth__box-title auth__box_${pref} auth__box-title_${pref}`}>
                        <div className={`auth__title auth__title_${pref}`}>{t('Login')}</div>
                    </div>
                    <Form onSubmit={onSubmit}>
                        <FormRow>
                            <WrapInput label="Email" name="email">
                                <Input
                                    value={email}
                                    type="email"
                                    onChange={(value) => onChange('email', value)}
                                    placeholder={t('Enter your email here')}
                                />
                            </WrapInput>
                        </FormRow>
                        <FormRow>
                            <WrapInput label="Password" name="password">
                                <Input
                                    type="password"
                                    value={password}
                                    onChange={(value) => onChange('password', value)}
                                    placeholder={t('Enter your password here')}
                                />
                            </WrapInput>
                        </FormRow>
                        <FormRow>
                            <div className={`auth__forgot auth__forgot_${pref}`}>
                                <a href="/forgot" className={`auth__forgot-link auth__forgot-link_${pref}`}>
                                    {t('Forgot Password?')}
                                </a>
                            </div>
                        </FormRow>
                        <FormRow>
                            <FormError title={error} />
                            <div className={`auth__box auth__box_${pref} auth__box-button auth__box-button_${pref}`}>
                                <RoundedButton name="login" type="submit" disabled={checkForm()}>
                                    {t('Login')}
                                </RoundedButton>
                            </div>
                        </FormRow>
                    </Form>
                    <FormRow>
                        <div className={`auth__box auth__box_${pref} auth__box-social auth__box-social_${pref}`}>
                            <ImageLink src="/auth/socials/connect/facebook" img="facebook" />
                            <ImageLink src="/auth/socials/connect/google" img="google" />
                        </div>
                    </FormRow>
                    <FormRow>
                        <div className={`auth__registration auth__registration_${pref}`}>
                            <a href="/registration" className={`auth__link auth__link_${pref}`}>
                                {t('Sing UP')}
                            </a>
                        </div>
                    </FormRow>
                </div>
            </div>
        </div>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        lastAction: getStoreItem(state, 'lastAction'),
        csrf_token: getStoreItem(state, 'csrf_token'),
        error: getStoreItem(state, 'error', ''),
    };
};
const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        submitForm: getActionStore('submitFormAction'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
