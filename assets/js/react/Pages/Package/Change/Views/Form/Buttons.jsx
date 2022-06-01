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
    _package: PropTypes.shape({
        id: PropTypes.string,
        name: PropTypes.string.isRequired,
        price_label: PropTypes.string.isRequired,
        price_month: PropTypes.string.isRequired,
        price_additional: PropTypes.string.isRequired,
        available_company: PropTypes.string.isRequired,
        api: PropTypes.arrayOf(PropTypes.string).isRequired,
        carriers: PropTypes.arrayOf(PropTypes.string).isRequired,
        useCarriers: PropTypes.arrayOf(PropTypes.string).isRequired,
        pickup: PropTypes.arrayOf(PropTypes.string).isRequired,
    }),
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
        dataRequestNormalizer: PropTypes.func.isRequired,
    }).isRequired,
    submitForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    onResetForm: PropTypes.func.isRequired,
    edit: PropTypes.bool,
};

const defaultProps = {
    _package: {
        id: '',
    },
    edit: false,
};

const Buttons = ({ _package, submitForm, validateForm, onResetForm, edit, service: { url }, t }) => {
    const oldFormHash = useRef(sha1(_package));
    const isFormChanged = oldFormHash.current !== sha1(_package);

    const submitRequest = async (cb) => {
        const { id } = await submitForm(_package, _package.id);
        if (id) {
            cb();
        }
    };

    const onSubmitAnother = () => {
        validateForm(_package, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'Package saved' });
                onResetForm();
            });
        });
    };

    const onSubmit = () => {
        validateForm(_package, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'Package saved' });
                _url.redirect(`/${url}`);
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
        _package: {
            id: getStoreItem(state, 'id', ''),
            name: getStoreItem(state, 'name', ''),
            price_label: getStoreItem(state, 'price_label', ''),
            price_month: getStoreItem(state, 'price_month', ''),
            price_additional: getStoreItem(state, 'price_additional', ''),
            available_company: getStoreItem(state, 'available_company', ''),
            api: getStoreItem(state, 'api', []),
            carriers: getStoreItem(state, 'carriers', []),
            useCarriers: getStoreItem(state, 'useCarriers', []),
            pickup: getStoreItem(state, 'pickup', []),
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
