import React, { useMemo } from 'react';
import PropTypes from 'prop-types';
import { equals } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, FormCol, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { addressTypeOptions } from 'Services/Enums';
import { countryList, StateList } from 'Services';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    data: PropTypes.shape({
        street1: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        typeAddress: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        country: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        state: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        city: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        zip: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
    }).isRequired,
};

const Address = ({ onChange, data }) => {
    const { street1, typeAddress, country, state, city, zip } = data;

    const renderStateField = useMemo(() => {
        const isUs = equals(country.value, 'US');
        const config = {
            label: isUs ? 'State' : 'Region',
            type: isUs ? 'searchSelect' : 'text',
            inputProps: isUs ? { options: StateList } : {},
        };

        return (
            <WrapInput name="state" label={config.label} errors={state.error} required>
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
        <>
            <FormRow>
                <WrapInput name="street1" label="Your address" errors={street1.error} required>
                    <Input value={street1.value} placeholder="Type address 1" onChange={onChange('street1')} />
                </WrapInput>
            </FormRow>
            <FormRow>
                <WrapInput name="typeAddress" label="Type address" errors={typeAddress.error} required>
                    <Input
                        type="select"
                        inputProps={{ options: addressTypeOptions }}
                        value={typeAddress.value}
                        onChange={onChange('typeAddress')}
                    />
                </WrapInput>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="country" label="Country" errors={country.error} required>
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
                    <WrapInput name="city" label="City" errors={city.error} required>
                        <Input type="city" value={city.value} onChange={onChange('city')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="zip" label="Zip" errors={zip.error} required>
                        <Input value={zip.value} onChange={onChange('zip')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </>
    );
};

Address.propTypes = propTypes;

export default withTagDefaultProps(Address);
