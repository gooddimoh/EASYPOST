import React, { useRef } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { sha1, url as _url } from 'Services';
import { FormCol } from 'Templates/Form';
import { BorderButton, ButtonsWrap } from 'Templates/Button';

const propTypes = {
    form: PropTypes.shape({
        csrf_token: PropTypes.string.isRequired,
        oldPassword: PropTypes.string.isRequired,
        password: PropTypes.string.isRequired,
        passwordRepeat: PropTypes.string.isRequired,
    }).isRequired,
    service: PropTypes.shape({
        validOnSubmit: PropTypes.func.isRequired,
    }).isRequired,
    submitForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
};

const Buttons = ({ form, t, submitForm, validateForm, service: { validOnSubmit } }) => {
    const oldFormHash = useRef(sha1(form));
    const isFormChanged = oldFormHash.current !== sha1(form);

    const submitRequest = async (cb) => {
        const { data } = await submitForm(form);
        if (data) {
            cb();
        }
    };

    const onSubmit = async () => {
        validateForm(validOnSubmit)(form, () => {
            submitRequest(() => {
                _url.redirect('/login');
            });
        });
    };

    return (
        <FormCol>
            <ButtonsWrap>
                <BorderButton onClick={onSubmit} name="save" disabled={!isFormChanged}>
                    {t('Save')}
                </BorderButton>
            </ButtonsWrap>
        </FormCol>
    );
};

Buttons.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            oldPassword: getStoreItem(state, 'oldPassword', ''),
            password: getStoreItem(state, 'password', ''),
            passwordRepeat: getStoreItem(state, 'passwordRepeat', ''),
            csrf_token: getStoreItem(state, 'csrf_token'),
        },
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        submitForm: getActionStore('submitFormAction'),
        validateForm: getActionStore('validateForm'),
        validPasswordOnSubmit: getActionStore('validPasswordOnSubmit'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Buttons);
