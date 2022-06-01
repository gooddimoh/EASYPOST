import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { compose, curry, includes } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { phoneList } from 'Services';
import { addressTypeOptions } from 'Services/Enums';
import { close } from 'Widgets/Modal';
import { Form, FormBody, FormRow, FormCol, FormTitle, FormFooter, WrapInput, WrapInputPhone } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { BorderButton } from 'Templates/Button';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    fillPickupForm: PropTypes.func.isRequired,
    validatePickupForm: PropTypes.func.isRequired,
    submitPickup: PropTypes.func.isRequired,
    nextModalScreen: PropTypes.func.isRequired,
    form: PropTypes.objectOf(PropTypes.any).isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        kModal: PropTypes.string.isRequired,
    }).isRequired,
    labelId: PropTypes.string.isRequired,
};

const PickupForm = ({
    onChange,
    fillPickupForm,
    validatePickupForm,
    submitPickup,
    nextModalScreen,
    form,
    errors,
    service: { kModal },
    labelId,
    t,
}) => {
    const { name, type, code, phone, email, street1, street2, city, zip, minDate, maxDate, instructions, useSender } =
        form;

    const _onChange = curry((key, value) => onChange(key, value));

    useEffect(() => {
        if (includes('useSender', useSender)) {
            fillPickupForm();
        }
    }, [JSON.stringify(useSender)]);

    const onSubmit = async () => {
        validatePickupForm(form, async () => {
            const { pickup_id } = await submitPickup(labelId, form);
            if (pickup_id) {
                nextModalScreen();
            }
        });
    };

    return (
        <>
            <Form>
                <FormBody>
                    <FormRow>
                        <FormTitle title="Label created, fill in the form fields to select pickup" />
                    </FormRow>
                    <FormRow>
                        <Input
                            type="checkbox"
                            name="useSender"
                            value={useSender}
                            inputProps={{
                                options: [{ value: 'useSender', label: 'Use current sender data' }],
                            }}
                            onChange={_onChange('useSender')}
                        />
                    </FormRow>

                    <FormRow>
                        <FormCol>
                            <WrapInput name="name" label="Full Name" errors={errors.name} required>
                                <Input value={name} onChange={_onChange('name')} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput name="type" label="Type" errors={errors.type} required>
                                <Input
                                    type="select"
                                    inputProps={{ options: addressTypeOptions }}
                                    value={type}
                                    onChange={_onChange('type')}
                                />
                            </WrapInput>
                        </FormCol>
                    </FormRow>

                    <FormRow>
                        <FormCol>
                            <WrapInput name="email" label="Email" errors={errors.email} required>
                                <Input value={email} onChange={_onChange('email')} />
                            </WrapInput>
                        </FormCol>
                    </FormRow>

                    <FormRow>
                        <FormCol>
                            <WrapInputPhone>
                                <WrapInput name="code" label="Phone Code" errors={errors.code} required>
                                    <Input
                                        type="searchSelect"
                                        value={code}
                                        inputProps={{ options: phoneList }}
                                        onChange={_onChange('code')}
                                    />
                                </WrapInput>
                                <WrapInput name="phone" label="Phone Number" errors={errors.phone} required>
                                    <Input value={phone} onChange={_onChange('phone')} />
                                </WrapInput>
                            </WrapInputPhone>
                        </FormCol>
                    </FormRow>

                    <FormRow>
                        <FormCol>
                            <WrapInput name="street1" label="Address 1" errors={errors.street1} required>
                                <Input value={street1} onChange={_onChange('street1')} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput name="street2" label="Address 2">
                                <Input value={street2} onChange={_onChange('street2')} />
                            </WrapInput>
                        </FormCol>
                    </FormRow>

                    <FormRow>
                        <FormCol>
                            <WrapInput name="city" label="City" errors={errors.city} required>
                                <Input value={city} onChange={_onChange('city')} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput name="zip" label="Zip Code" errors={errors.zip} required>
                                <Input value={zip} onChange={_onChange('zip')} />
                            </WrapInput>
                        </FormCol>
                    </FormRow>

                    <FormRow>
                        <FormCol>
                            <WrapInput name="minDate" label="Min Date" errors={errors.minDate} required>
                                <Input type="dateTime" value={minDate} onChange={_onChange('minDate')} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput name="maxDate" label="Max Date" errors={errors.maxDate} required>
                                <Input type="dateTime" value={maxDate} onChange={_onChange('maxDate')} />
                            </WrapInput>
                        </FormCol>
                    </FormRow>
                    <FormRow>
                        <WrapInput name="instructions" label="Instructions" errors={errors.instructions} required>
                            <Input type="textarea" value={instructions} onChange={_onChange('instructions')} />
                        </WrapInput>
                    </FormRow>
                </FormBody>
                <FormFooter>
                    <BorderButton name="cancel" onClick={() => close(kModal)}>
                        {t('Cancel')}
                    </BorderButton>
                    <BorderButton name="get-pickup-rates" type="submit" onClick={onSubmit}>
                        {t('Get pickup rates')}
                    </BorderButton>
                </FormFooter>
            </Form>
        </>
    );
};

PickupForm.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        form: {
            name: getStoreItem(state, ['pickupForm', 'name'], ''),
            type: getStoreItem(state, ['pickupForm', 'type'], ''),
            code: getStoreItem(state, ['pickupForm', 'code'], ''),
            phone: getStoreItem(state, ['pickupForm', 'phone'], ''),
            email: getStoreItem(state, ['pickupForm', 'email'], ''),
            street1: getStoreItem(state, ['pickupForm', 'street1'], ''),
            street2: getStoreItem(state, ['pickupForm', 'street2'], ''),
            city: getStoreItem(state, ['pickupForm', 'city'], ''),
            state: getStoreItem(state, ['pickupForm', 'state'], ''),
            country: getStoreItem(state, ['pickupForm', 'country'], ''),
            zip: getStoreItem(state, ['pickupForm', 'zip'], ''),
            minDate: getStoreItem(state, ['pickupForm', 'minDate'], ''),
            maxDate: getStoreItem(state, ['pickupForm', 'maxDate'], ''),
            instructions: getStoreItem(state, ['pickupForm', 'instructions'], ''),
            useSender: getStoreItem(state, ['pickupForm', 'useSender'], []),
        },
        labelId: getStoreItem(state, ['labelId'], ''),
        errors: getStoreItem(state, ['formErrors'], {}),
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        onChange: getActionStore('onChangePickup'),
        fillPickupForm: getActionStore('fillPickupForm'),
        validatePickupForm: getActionStore('validatePickupForm'),
        submitPickup: getActionStore('submitPickupAction'),
        nextModalScreen: getActionStore('nextModalScreen'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(PickupForm);
