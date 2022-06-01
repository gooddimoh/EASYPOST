import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { TableWidget } from 'Widgets/Table';
import { close } from 'Widgets/Modal';
import { Form, FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';

const propTypes = {
    form: PropTypes.objectOf(PropTypes.any).isRequired,
    shipmentId: PropTypes.string.isRequired,
    rateId: PropTypes.string.isRequired,
    submitForm: PropTypes.func.isRequired,
    submit: PropTypes.func.isRequired,
    service: PropTypes.shape({
        kModal: PropTypes.string.isRequired,
    }).isRequired,
};

const LabelRates = ({ form, shipmentId, rateId, submitForm, submit, service, t }) => {
    const { kModal } = service;

    const onSubmit = () => {
        submit(async () => {
            const { id } = await submitForm({ ...form, shipmentId, rateId });
            return id;
        });
    };

    return (
        <>
            <TableWidget />
            <Form>
                <FormFooter>
                    <BorderButton name="cancel" onClick={() => close(kModal)}>
                        {t('Cancel')}
                    </BorderButton>
                    <BorderButton name="buy-label" type="submit" disabled={!(shipmentId && rateId)} onClick={onSubmit}>
                        {t('Buy label')}
                    </BorderButton>
                </FormFooter>
            </Form>
        </>
    );
};

LabelRates.propTypes = propTypes;

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
            type: getStoreItem(state, 'type', null),
            pickup: getStoreItem(state, 'pickup', []),
        },
        shipmentId: getStoreItem(state, ['shipment_id'], ''),
        rateId: getStoreItem(state, ['rateId'], ''),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => ({
    submitForm: getActionStore('submitFormAction'),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(LabelRates);
