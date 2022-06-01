import React, { useMemo, useRef } from 'react';
import { compose, toString, equals } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, WrapInputPhone, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { countryList, phoneList, StateList } from 'Services';
import { addressTypeOptions, addressBookType } from 'Services/Enums';

const propTypes = {
    name: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    street1: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    typeAddress: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    city: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    state: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    zip: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    street2: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    country: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    code: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    phone: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    email: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    description: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    type: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
};

const Block = ({
    name,
    street1,
    typeAddress,
    city,
    state,
    zip,
    street2,
    country,
    code,
    phone,
    email,
    description,
    type,
    onChange,
}) => {
    const disableCountry = useRef(equals(type, addressBookType.sender));
    const renderStateField = useMemo(() => {
        const isUs = equals(country.value, 'US');
        const config = {
            label: isUs ? 'State' : 'Region',
            type: isUs ? 'searchSelect' : 'text',
            inputProps: isUs ? { options: StateList } : {},
        };

        return (
            <WrapInput name="state" label={config.label} errors={state.errors} required>
                <Input
                    type={config.type}
                    inputProps={config.inputProps}
                    value={state.value}
                    onChange={onChange('state')}
                />
            </WrapInput>
        );
    }, [state, country.value]);

    return (
        <FormBody>
            <FormRow>
                <FormTitle title="General info" />
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="name" label="Full name" errors={name.errors} required>
                        <Input value={name.value} onChange={onChange('name')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput
                        name="country"
                        label="Country"
                        errors={country.errors}
                        required
                        disabled={disableCountry.current}
                    >
                        <Input
                            type="searchSelect"
                            value={country.value}
                            inputProps={{ options: countryList }}
                            onChange={onChange('country')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>{renderStateField}</FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="city" label="City" errors={city.errors} required>
                        <Input type="city" value={city.value} onChange={onChange('city')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="street1" label="Address 1" errors={street1.errors} required>
                        <Input value={street1.value} onChange={onChange('street1')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="street2" label="Address 2" errors={street2.errors} required>
                        <Input value={street2.value} onChange={onChange('street2')} />
                    </WrapInput>
                </FormCol>
            </FormRow>

            <FormRow>
                <FormCol columnSize={8} fromColumns={12}>
                    <FormRow>
                        <FormCol>
                            <WrapInput name="typeAddress" label="Type address" errors={typeAddress.errors} required>
                                <Input
                                    type="select"
                                    inputProps={{ options: addressTypeOptions }}
                                    value={typeAddress.value}
                                    onChange={onChange('typeAddress')}
                                />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput name="zip" label="Zip" errors={zip.errors} required>
                                <Input value={zip.value} onChange={onChange('zip')} />
                            </WrapInput>
                        </FormCol>
                    </FormRow>
                    <FormRow>
                        <FormTitle title="Contact info" />
                    </FormRow>
                    <FormRow>
                        <FormCol>
                            <WrapInput name="email" label="Email" errors={email.errors} required>
                                <Input value={email.value} onChange={onChange('email')} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInputPhone>
                                <WrapInput name="code" label="Code" errors={code.errors} required>
                                    <Input
                                        type="searchSelect"
                                        value={code.value}
                                        inputProps={{ options: phoneList }}
                                        onChange={onChange('code')}
                                    />
                                </WrapInput>
                                <WrapInput name="phone" label="Phone" errors={phone.errors} required>
                                    <Input value={phone.value} onChange={onChange('phone')} />
                                </WrapInput>
                            </WrapInputPhone>
                        </FormCol>
                    </FormRow>
                </FormCol>
                <FormCol columnSize={4} fromColumns={12}>
                    <WrapInput name="description" label="Description" errors={description.errors} required>
                        <Input type="textarea" value={description.value} onChange={onChange('description')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </FormBody>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        name: {
            value: getStoreItem(state, 'name', ''),
            errors: getStoreItem(state, ['formErrors', 'name'], []),
        },
        street1: {
            value: getStoreItem(state, 'street1', ''),
            errors: getStoreItem(state, ['formErrors', 'street1'], []),
        },
        typeAddress: {
            value: getStoreItem(state, 'typeAddress', ''),
            errors: getStoreItem(state, ['formErrors', 'typeAddress'], []),
        },
        city: {
            value: getStoreItem(state, 'city', ''),
            errors: getStoreItem(state, ['formErrors', 'city'], []),
        },
        state: {
            value: getStoreItem(state, 'state', ''),
            errors: getStoreItem(state, ['formErrors', 'state'], []),
        },
        zip: {
            value: getStoreItem(state, 'zip', ''),
            errors: getStoreItem(state, ['formErrors', 'zip'], []),
        },
        street2: {
            value: getStoreItem(state, 'street2', ''),
            errors: getStoreItem(state, ['formErrors', 'street2'], []),
        },
        country: {
            value: getStoreItem(state, 'country', ''),
            errors: getStoreItem(state, ['formErrors', 'country'], []),
        },
        code: {
            value: getStoreItem(state, 'code', ''),
            errors: getStoreItem(state, ['formErrors', 'code'], []),
        },
        phone: {
            value: getStoreItem(state, 'phone', ''),
            errors: getStoreItem(state, ['formErrors', 'phone'], []),
        },
        email: {
            value: getStoreItem(state, 'email', ''),
            errors: getStoreItem(state, ['formErrors', 'email'], []),
        },
        description: {
            value: getStoreItem(state, 'description', ''),
            errors: getStoreItem(state, ['formErrors', 'description'], []),
        },
        type: toString(getStoreItem(state, 'type', '')),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
