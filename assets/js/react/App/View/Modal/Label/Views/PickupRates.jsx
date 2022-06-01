import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { TableWidget } from 'Widgets/Table';
import { Form, FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { modalViewsEnum } from 'Services/Enums';

const propTypes = {
    labelId: PropTypes.string.isRequired,
    pickupId: PropTypes.string.isRequired,
    pickupRateId: PropTypes.string.isRequired,
    requestGetPickup: PropTypes.func.isRequired,
    submit: PropTypes.func.isRequired,
    goToScreen: PropTypes.func.isRequired,
};

const PickupRates = ({ labelId, pickupId, pickupRateId, requestGetPickup, submit, goToScreen, t }) => {
    const onSubmit = () => {
        submit(async () => {
            const data = { pickup_id: pickupId, pickup_rate_id: pickupRateId };
            const { id } = await requestGetPickup(labelId, data);
            return id;
        });
    };

    return (
        <>
            <TableWidget />
            <Form>
                <FormFooter>
                    <BorderButton name="back" onClick={() => goToScreen(modalViewsEnum.pickupForm)}>
                        {t('Back to pickup form')}
                    </BorderButton>
                    <BorderButton
                        name="buy-pickup"
                        type="submit"
                        disabled={!(pickupId && pickupRateId)}
                        onClick={onSubmit}
                    >
                        {t('Buy pickup')}
                    </BorderButton>
                </FormFooter>
            </Form>
        </>
    );
};

PickupRates.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        labelId: getStoreItem(state, ['labelId'], ''),
        pickupId: getStoreItem(state, ['pickup_id'], ''),
        pickupRateId: getStoreItem(state, ['rateId'], ''),
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        requestGetPickup: getActionStore('requestGetPickup'),
        goToScreen: getActionStore('goToScreen'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(PickupRates);
