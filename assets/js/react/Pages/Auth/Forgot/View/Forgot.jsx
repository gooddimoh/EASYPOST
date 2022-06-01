import React, {useState} from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { Form, FormRow } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { RoundedButton } from 'Templates/Button';
import { BackLink } from 'Templates/Title';

const propTypes = {
    submitForm: PropTypes.func.isRequired,
    service: PropTypes.shape({
        getStoreItem: PropTypes.func.isRequired,
        getActionStore: PropTypes.func.isRequired,
    }).isRequired,
};

const Forgot = ({ submitForm, pref, t }) => {
    const [state, setState] = useState({
        email: ''
    });
    const { email } = state;

    const onChange = (value) => setState({ ...state, email: value });
    const checkForm = () => !state.email;
    const onSubmit = () => submitForm({ email: state.email });

    return (
        <div className={`main-wrap main-wrap_${pref} auth`}>
            <div className={`auth__wrap auth__wrap_${pref}`}>
                <div className={`auth__content auth__content_${pref}`}>
                    <div className={`auth__box auth__box-title auth__box_${pref} auth__box-title_${pref}`}>
                        <BackLink url="/login" />
                        <div className={`auth__title auth__title_${pref}`}>{t('Reset Your Password')}</div>
                    </div>

                    <Form onSubmit={onSubmit} className={`auth__form auth__form_${pref}`}>
                        <FormRow>
                            <Input
                                required
                                id="email"
                                type="email"
                                name="email"
                                placeholder={t('Enter your email here')}
                                value={email}
                                onChange={(value) => onChange(value)}
                            />
                        </FormRow>
                        <FormRow>
                            <div className={`auth__box auth__box_${pref} auth__box-desc auth__box-desc_${pref}`}>
                                <div className={`auth__desc-forgot auth__desc-forgot_${pref}`}>
                                    {t('We’ll email you instructions to reset your password.')}
                                </div>
                            </div>
                        </FormRow>
                        <FormRow>
                            <div className={`auth__box auth__box_${pref} auth__box-button auth__box-button_${pref}`}>
                                <RoundedButton name="reset" type="submit" disabled={checkForm()}>
                                    {t('Reset password')}
                                </RoundedButton>
                            </div>
                        </FormRow>
                    </Form>
                </div>
            </div>
        </div>
    );
};

Forgot.propTypes = propTypes;

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        submitForm: getActionStore('submitFormAction'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(Forgot);
