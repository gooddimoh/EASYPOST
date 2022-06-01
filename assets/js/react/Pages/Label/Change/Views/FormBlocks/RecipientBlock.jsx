import React, { useMemo } from 'react';
import PropTypes from 'prop-types';
import { curry, compose, equals, toString } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { countryList, StateList, url as _url } from 'Services';
import { labelType } from 'Services/Enums';
import { FormBody, FormCol, FormRow, FormTitle, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import MainFormBlock from './MainFormBlock';

const propTypes = {
    data: PropTypes.shape({
        id: PropTypes.string.isRequired,
        state: PropTypes.string.isRequired,
        country: PropTypes.string.isRequired,
    }).isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    onChange: PropTypes.func.isRequired,
    request: PropTypes.func.isRequired,
    type: PropTypes.string.isRequired,
};

const RecipientBlock = ({ data, errors, onChange, request, type }) => {
    const { state, country } = data;
    const _onChange = curry((domain, key, value) => onChange([domain, key], value));

    const isUs = useMemo(() => equals(country, 'US'), [country]);
    const isLocal = useMemo(() => equals(type, labelType.local), []);

    const configStateSelect = useMemo(
        () => ({
            label: isUs ? 'State' : 'Region',
            type: isUs ? 'searchSelect' : 'text',
            inputProps: isUs ? { options: StateList } : {},
        }),
        [isUs],
    );

    const selectOptions = useMemo(() => {
        const urlParams = isLocal ? `?${_url.queryParamEncode({ country: 'US' })}` : '';
        return {
            label: 'Select recipient',
            name: 'recipient',
            url: `/address-books/recipient-list${urlParams}`,
        };
    }, []);

    return (
        <FormBody>
            <FormRow>
                <FormTitle title="Recipient" />
            </FormRow>

            <MainFormBlock
                data={data}
                errors={errors}
                onChange={_onChange('recipient')}
                request={request}
                selectOptions={selectOptions}
            />

            <FormRow>
                <FormCol>
                    <WrapInput name="country" label="Country" errors={errors.country} required disabled={isLocal}>
                        <Input
                            type="searchSelect"
                            value={country}
                            inputProps={{ options: countryList }}
                            onChange={_onChange('recipient', 'country')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="state" label={configStateSelect.label} errors={errors.state} required>
                        <Input
                            type={configStateSelect.type}
                            value={state}
                            inputProps={configStateSelect.inputProps}
                            onChange={_onChange('recipient', 'state')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol />
            </FormRow>
        </FormBody>
    );
};

RecipientBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        data: {
            id: getStoreItem(state, ['recipient', 'id'], ''),
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
        type: toString(getStoreItem(state, 'type', null)),
        errors: getStoreItem(state, ['formErrors', 'recipient'], {}),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
        request: getActionStore('requestAddressById'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(RecipientBlock);
