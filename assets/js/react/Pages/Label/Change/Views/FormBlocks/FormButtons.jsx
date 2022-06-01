import React from 'react';
import PropTypes from 'prop-types';
import { compose, toString, cond, T, F } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormCol } from 'Templates/Form';
import { BorderButton, ButtonsWrap } from 'Templates/Button';
import { showModal, showRegistrationModal } from 'Widgets/Modal';
import LabelModal from 'App/View/Modal/Label';
import { modalViewsEnum } from 'Services/Enums';
import { url as _url } from 'Services';

const propTypes = {
    requestGetRates: PropTypes.func.isRequired,
    goToScreen: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    form: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        createDraft: PropTypes.func.isRequired,
        editDraft: PropTypes.func.isRequired,
        url: PropTypes.string.isRequired,
    }).isRequired,
    isEdit: PropTypes.bool,
    labelId: PropTypes.string.isRequired,
    activePackage: PropTypes.string,
    confirmed: PropTypes.bool.isRequired,
};

const defaultProps = {
    isEdit: false,
    activePackage: '',
};

const FormButtons = ({
    requestGetRates,
    goToScreen,
    validateForm,
    form,
    labelId,
    service,
    isEdit,
    activePackage,
    confirmed,
    t,
}) => {
    const requestCreateDraft = async () => {
        const { id } = await service.createDraft(form);
        return id;
    };

    const onEditDraft = () => {
        validateForm(form, async () => {
            const { id } = await service.editDraft(labelId, form);
            if (id) _url.redirect(`/${service.url}`);
        });
    };

    const onCreateDraft = () => {
        validateForm(form, async () => {
            const next = await requestCreateDraft();
            if (next) _url.redirect(`/${service.url}`);
        });
    };

    const getLabelRates = async () => {
        await requestGetRates(form);
        showModal(<LabelModal createDraft={requestCreateDraft} />, () => goToScreen(modalViewsEnum.labelRates));
    };

    const checkUserFlow = () => {
        const registrationModal = () => (confirmed ? getLabelRates() : showRegistrationModal(getLabelRates));
        return cond([
            [() => !activePackage, F],
            [() => activePackage && !confirmed, registrationModal],
            [T, getLabelRates],
        ])(activePackage, confirmed);
    };

    const onSubmit = () => validateForm(form, () => checkUserFlow());

    return (
        <FormCol>
            <ButtonsWrap>
                {isEdit ? (
                    <BorderButton key="edit-template" onClick={onEditDraft} type="submit" name="edit-template">
                        {t('Save template')}
                    </BorderButton>
                ) : (
                    <>
                        <BorderButton key="save-as-template" onClick={onCreateDraft} name="save-as-template">
                            {t('Save as template')}
                        </BorderButton>
                        <BorderButton key="get-rates" onClick={onSubmit} type="submit" name="get-rates">
                            {t('Get rates now')}
                        </BorderButton>
                    </>
                )}
            </ButtonsWrap>
        </FormCol>
    );
};

FormButtons.propTypes = propTypes;
FormButtons.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            sender: {
                name: getStoreItem(state, ['sender', 'name'], ''),
                type: getStoreItem(state, ['sender', 'type'], ''),
                code: getStoreItem(state, ['sender', 'code'], ''),
                phone: getStoreItem(state, ['sender', 'phone'], ''),
                email: getStoreItem(state, ['sender', 'email'], ''),
                street1: getStoreItem(state, ['sender', 'street1'], ''),
                street2: getStoreItem(state, ['sender', 'street2'], ''),
                city: getStoreItem(state, ['sender', 'city'], ''),
                state: getStoreItem(state, ['sender', 'state'], ''),
                country: getStoreItem(state, ['sender', 'country'], ''),
                zip: getStoreItem(state, ['sender', 'zip'], ''),
                description: getStoreItem(state, ['sender', 'description'], ''),
            },
            recipient: {
                name: getStoreItem(state, ['recipient', 'name'], ''),
                type: getStoreItem(state, ['recipient', 'type'], ''),
                code: getStoreItem(state, ['recipient', 'code'], ''),
                phone: getStoreItem(state, ['recipient', 'phone'], ''),
                email: getStoreItem(state, ['recipient', 'email'], ''),
                street1: getStoreItem(state, ['recipient', 'street1'], ''),
                street2: getStoreItem(state, ['recipient', 'street2'], ''),
                city: getStoreItem(state, ['recipient', 'city'], ''),
                state: getStoreItem(state, ['recipient', 'state'], ''),
                country: getStoreItem(state, ['recipient', 'country'], ''),
                zip: getStoreItem(state, ['recipient', 'zip'], ''),
                description: getStoreItem(state, ['recipient', 'description'], ''),
            },
            packages: getStoreItem(state, 'packages', []),
            price: getStoreItem(state, 'price', ''),
            weight: getStoreItem(state, 'weight', ''),
            parcel: {
                length: getStoreItem(state, ['parcel', 'length'], ''),
                width: getStoreItem(state, ['parcel', 'width'], ''),
                height: getStoreItem(state, ['parcel', 'height'], ''),
            },
            pickup: getStoreItem(state, 'pickup', []),
            type: toString(getStoreItem(state, 'type', '')),
        },
        labelId: getStoreItem(state, 'id', ''),
        activePackage: state.userState.activePackage,
        confirmed: state.userState.confirmed,
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        requestGetRates: getActionStore('requestGetRates'),
        goToScreen: getActionStore('goToScreen'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(FormButtons);
