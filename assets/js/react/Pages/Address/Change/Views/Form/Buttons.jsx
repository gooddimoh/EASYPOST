import React, { useRef } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { md5, url as _url, getStringFromList } from 'Services';
import { FormCol } from 'Templates/Form';
import { ButtonsWrap, BorderButton } from 'Templates/Button';
import { NotificationWrap } from 'Widgets/NotificationWrap';
import { addressBookTypeOptions } from 'Services/Enums';

const propTypes = {
    _id: PropTypes.string,
    form: PropTypes.shape({
        name: PropTypes.string.isRequired,
        street1: PropTypes.string.isRequired,
        type: PropTypes.number.isRequired,
        typeAddress: PropTypes.string.isRequired,
        city: PropTypes.string.isRequired,
        state: PropTypes.string.isRequired,
        zip: PropTypes.string.isRequired,
        street2: PropTypes.string.isRequired,
        country: PropTypes.string.isRequired,
        code: PropTypes.string.isRequired,
        phone: PropTypes.string.isRequired,
        email: PropTypes.string.isRequired,
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
    _id: '',
    edit: false,
};

const Buttons = ({ form, t, submitForm, onResetForm, validateForm, edit, _id, service: { url } }) => {
    const oldFormHash = useRef(md5(form));
    const isFormChanged = oldFormHash.current !== md5(form);

    const submitRequest = async (cb) => {
        const { id } = await submitForm(form, _id);
        if (id) {
            cb();
        }
    };

    const notificationText = getStringFromList(form.type, addressBookTypeOptions);

    const onSubmitAnother = () => {
        validateForm(form, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: `${notificationText} saved` });
                onResetForm();
            });
        });
    };

    const onSubmit = () => {
        validateForm(form, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: `${notificationText} saved` });
                _url.redirect(`/${url}`);
            });
        });
    };

    return (
        <FormCol>
            <ButtonsWrap>
                {!edit && (
                    <BorderButton disabled={!isFormChanged} onClick={onSubmitAnother} name="save-add-another">
                        {t('Save & Add Another')}
                    </BorderButton>
                )}
                <BorderButton disabled={!isFormChanged} onClick={onSubmit} name="save">
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
            street1: getStoreItem(state, 'street1', ''),
            type: getStoreItem(state, 'type', 0),
            typeAddress: getStoreItem(state, 'typeAddress', ''),
            city: getStoreItem(state, 'city', ''),
            state: getStoreItem(state, 'state', ''),
            zip: getStoreItem(state, 'zip', ''),
            street2: getStoreItem(state, 'street2', ''),
            country: getStoreItem(state, 'country', ''),
            code: getStoreItem(state, 'code', ''),
            phone: getStoreItem(state, 'phone', ''),
            email: getStoreItem(state, 'email', ''),
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
