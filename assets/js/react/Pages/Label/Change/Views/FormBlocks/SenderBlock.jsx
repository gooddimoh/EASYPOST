import React, { useMemo } from 'react';
import PropTypes from 'prop-types';
import { curry, compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { countryList, StateList, url as _url } from 'Services';
import { FormBody, FormCol, FormRow, FormTitle, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import MainFormBlock from './MainFormBlock';

const propTypes = {
    data: PropTypes.shape({
        country: PropTypes.string.isRequired,
        state: PropTypes.string.isRequired,
    }).isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    onChange: PropTypes.func.isRequired,
    request: PropTypes.func.isRequired,
};

const SenderBlock = ({ data, errors, onChange, request }) => {
    const { country, state } = data;
    const _onChange = curry((domain, key, value) => onChange([domain, key], value));

    const selectOptions = useMemo(
        () => ({
            label: 'Select sender',
            name: 'sender',
            url: `/address-books/sender-list?${_url.queryParamEncode({ country: 'US' })}`,
        }),
        [],
    );

    return (
        <FormBody>
            <FormRow>
                <FormTitle title="Sender" />
            </FormRow>

            <MainFormBlock
                data={data}
                errors={errors}
                onChange={_onChange('sender')}
                request={request}
                selectOptions={selectOptions}
            />

            <FormRow>
                <FormCol>
                    <WrapInput name="country" label="Country" errors={errors.country} required disabled>
                        <Input
                            type="searchSelect"
                            value={country}
                            inputProps={{ options: countryList }}
                            onChange={_onChange('sender', 'country')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="state" label="State" errors={errors.state} required>
                        <Input
                            type="searchSelect"
                            value={state}
                            inputProps={{ options: StateList }}
                            onChange={_onChange('sender', 'state')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol />
            </FormRow>
        </FormBody>
    );
};

SenderBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        data: {
            id: getStoreItem(state, ['sender', 'id'], ''),
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
        errors: getStoreItem(state, ['formErrors', 'sender'], {}),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
        request: getActionStore('requestAddressById'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(SenderBlock);
