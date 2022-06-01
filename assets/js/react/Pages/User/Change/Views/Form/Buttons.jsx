import React, { useRef } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { sha1, url as _url } from 'Services';
import { FormCol } from 'Templates/Form';
import { ButtonsWrap, BorderButton } from 'Templates/Button';
import { NotificationWrap } from 'Widgets/NotificationWrap';

const propTypes = {
    _id: PropTypes.string,
    form: PropTypes.shape({
        name: PropTypes.string.isRequired,
        email: PropTypes.string.isRequired,
        company: PropTypes.string.isRequired,
        photo: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
        role: PropTypes.string.isRequired,
    }).isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
        validOnSubmit: PropTypes.func.isRequired,
    }).isRequired,
    submitForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    onResetForm: PropTypes.func.isRequired,
    edit: PropTypes.bool,
};

const defaultProps = {
    _id: '',
    edit: false,
};

const Buttons = ({ form, _id, t, submitForm, onResetForm, edit, validateForm, service: { url, validOnSubmit } }) => {
    const oldFormHash = useRef(sha1(form));
    const isFormChanged = oldFormHash.current !== sha1(form);

    const submitRequest = async (cb) => {
        const { id } = await submitForm(form, _id);
        if (id) {
            cb(id);
        }
    };

    const onSubmit = async () => {
        validateForm(validOnSubmit)(form, () => {
            submitRequest((id) => {
                _url.redirect(`/${url}/${id}`);
            });
        });
    };

    const onSubmitAnother = async () => {
        validateForm(validOnSubmit)(form, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'Package saved' });
                onResetForm();
            });
        });
    };

    return (
        <FormCol>
            <ButtonsWrap>
                {!edit && (
                    <BorderButton onClick={onSubmitAnother} name="save-add-another" disabled={!isFormChanged}>
                        {t('Save & Add Another')}
                    </BorderButton>
                )}
                <BorderButton onClick={onSubmit} name="save" disabled={!isFormChanged}>
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
        _id: getStoreItem(state, 'id', ''),
        form: {
            name: getStoreItem(state, 'name', ''),
            email: getStoreItem(state, 'email', ''),
            company: getStoreItem(state, 'company', ''),
            photo: getStoreItem(state, 'photo', ''),
            role: getStoreItem(state, 'role', ''),
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
