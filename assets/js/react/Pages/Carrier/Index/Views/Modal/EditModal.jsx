import React, {useState} from 'react';
import PropTypes from 'prop-types';
import {compose, curry} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {schemaCall} from 'Services';
import {carriersType} from 'Services/Enums';
import connect from 'Hoc/Template/Connect';
import {Form, FormFooter} from 'Templates/Form';
import {BorderButton} from 'Templates/Button';
import {close} from 'Widgets/Modal';
import {ModalFedEx, ModalUPS} from './Templates';

const propTypes = {
    kModal: PropTypes.string,
    item: PropTypes.objectOf(PropTypes.any).isRequired,
    onSubmit: PropTypes.func.isRequired,
    updateCarrier: PropTypes.func.isRequired,
    service: PropTypes.shape({
        validOnSubmit: PropTypes.func.isRequired,
    }).isRequired,
};

const defaultProps = {
    kModal: '',
};

const EditModal = ({kModal, item, onSubmit, updateCarrier, service: {validOnSubmit}, t}) => {
    const [state, setState] = useState({});

    const _onChange = curry((keys, value) => setState({...state, [keys]: value}));

    const modalCarriers = schemaCall({
        [carriersType.ups]: () => <ModalUPS item={item} state={state} setState={setState} onChange={_onChange}/>,
        [carriersType.fedex]: () => <ModalFedEx item={item} state={state} setState={setState} onChange={_onChange}/>,
    });

    const validateForm = (formData, cb) => {
        const data = validOnSubmit(formData);

        return data.formValidate
            ? cb()
            : setState({...state, errors: data.formErrors});
    };


    const submitRequest = async (cb) => {
        const {id} = await onSubmit({...item, credentials: state});
        if (id) {
            cb();
        }
    };

    const onClickSave = async () => {
        validateForm({...item, credentials: state}, () => {
            submitRequest(() => {
                updateCarrier();
                close(kModal);
            });
        });
    };

    return (
        <Form>
            {modalCarriers(item.type)}
            <FormFooter>
                <BorderButton name="cancel" onClick={() => close(kModal)}>{t('Cancel')}</BorderButton>
                <BorderButton name="save" onClick={onClickSave}>{t('Save')}</BorderButton>
            </FormFooter>
        </Form>
    );
};

EditModal.propTypes = propTypes;
EditModal.defaultProps = defaultProps;

const mapStateToProps = (state, {service: {getStoreItem}}) => {

    const items = getStoreItem(state, 'items', []);
    const showIndex = getStoreItem(state, 'showIndex');

    return {
        item: items[showIndex],
        showIndex,
    };
};

const mapDispatchToProps = ({service, item}) => {

    const {getActionStore} = service;

    return {
        updateCarrier: getActionStore('updateCarrier'),
        onSubmit: getActionStore(item.custom ? 'editCarrier' : 'createCarrier'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(EditModal);
