import React from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { url as _url } from 'Services';
import { withTagDefaultProps } from 'Hoc/Template';
import { RoundedButton } from 'Templates/Button';
import { FormCol, FormRow } from 'Templates/Form';
import {ImageLink} from 'Templates/Link';

const propTypes = {
    setSuccess: PropTypes.func.isRequired,
    form: PropTypes.shape({
        email: PropTypes.string.isRequired,
    }).isRequired,

    service: PropTypes.shape({
        getStoreItem: PropTypes.func.isRequired,
        getActionStore: PropTypes.func.isRequired,
        userRequest: PropTypes.func.isRequired,
        companyRequest: PropTypes.func.isRequired,
    }).isRequired,
    createRequest: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    pref: PropTypes.string.isRequired,
};

const ButtonBlock = ({ setSuccess, validateForm, form, t, createRequest, pref }) => {
    const onSubmit = () => {
        validateForm(form, () => {
            setTimeout(async () => {
                await createRequest(form);
                _url.redirect('/');
            }, 100);

            setSuccess(true);
        });
    };

    return (
        <>
            <FormRow>
                <FormCol>
                    <div className={`auth__box auth__box_${pref} auth__box-button auth__box-button_${pref}`}>
                        <RoundedButton onClick={onSubmit} name="registration">
                            {t('Registration')}
                        </RoundedButton>
                    </div>
                </FormCol>
            </FormRow>
            <FormRow>
                <div className={`auth__box auth__box_${pref} auth__box-social auth__box-social_${pref}`}>
                    <ImageLink src="/auth/socials/connect/facebook" img='facebook' />
                    <ImageLink src="/auth/socials/connect/google" img='google' />
                </div>
            </FormRow>
            <FormRow>
                <div className={`auth__registration auth__registration_${pref}`}>
                    <a href="/login" className={`auth__link auth__link_${pref}`}>
                        {t('Sing IN')}
                    </a>
                </div>
            </FormRow>
        </>
    );
};

ButtonBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            email: getStoreItem(state, 'email', ''),
            role: getStoreItem(state, 'role', ''),
        },
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        createRequest: getActionStore('submitFormAction'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(ButtonBlock);
