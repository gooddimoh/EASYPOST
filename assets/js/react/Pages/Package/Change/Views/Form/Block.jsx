import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { permissionsEnum } from 'Services/Enums';

const propTypes = {
    name: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    price_label: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    price_month: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    price_additional: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    available_company: PropTypes.string.isRequired,
    carriersOptions: PropTypes.arrayOf(PropTypes.object).isRequired,
    carriers: PropTypes.arrayOf(PropTypes.string).isRequired,
    useCarriers: PropTypes.arrayOf(PropTypes.string).isRequired,
    api: PropTypes.arrayOf(PropTypes.string).isRequired,
    pickup: PropTypes.arrayOf(PropTypes.string).isRequired,
    onChange: PropTypes.func.isRequired,
    onChangeUseCarriers: PropTypes.func.isRequired,
};

const Block = ({
    name,
    price_label,
    price_month,
    price_additional,
    carriers,
    useCarriers,
    api,
    pickup,
    carriersOptions,
    available_company,
    onChange,
    onChangeUseCarriers,
}) => {
    return (
        <FormBody>
            <FormRow>
                <FormTitle title="General Info" />
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="name" label="Package name" errors={name.errors} required>
                        <Input value={name.value} onChange={onChange('name')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="available_company" label="Available company">
                        <Input
                            type="asyncSelect"
                            inputProps={{ url: '/companies/list' }}
                            value={available_company}
                            onChange={onChange('available_company')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="price_label" label="Label price" errors={price_label.errors} required>
                        <Input value={price_label.value} onChange={onChange('price_label')} />
                    </WrapInput>
                </FormCol>
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="price_month" label="Month price" errors={price_month.errors} required>
                        <Input value={price_month.value} onChange={onChange('price_month')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput
                        name="price_additional"
                        label="Additional price"
                        errors={price_additional.errors}
                        required
                    >
                        <Input value={price_additional.value} onChange={onChange('price_additional')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <FormRow>
                        <FormCol>
                            <WrapInput name="pickup" label="Pickup" required>
                                <Input
                                    type="checkbox"
                                    value={pickup}
                                    inputProps={{
                                        options: [{ value: permissionsEnum.pickup, label: 'Pickup' }],
                                    }}
                                    onChange={onChange('pickup')}
                                />
                            </WrapInput>
                        </FormCol>

                        <FormCol>
                            <WrapInput name="API" label="API acceess" required>
                                <Input
                                    type="checkbox"
                                    value={api}
                                    inputProps={{
                                        options: [{ value: permissionsEnum.api, label: 'API access' }],
                                    }}
                                    onChange={onChange('api')}
                                />
                            </WrapInput>
                        </FormCol>

                        <FormCol />
                    </FormRow>
                </FormCol>
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="useCarriers" label="Can use carriers" required>
                        <Input
                            type="checkbox"
                            value={useCarriers}
                            inputProps={{
                                options: carriersOptions,
                            }}
                            onChange={onChangeUseCarriers('useCarriers')}
                        />
                    </WrapInput>
                </FormCol>

                <FormCol>
                    <WrapInput name="carriers" label="Can edit carriers" required>
                        <Input
                            type="checkbox"
                            value={carriers}
                            inputProps={{
                                options: carriersOptions,
                                isOptionDisabled: (option) => !useCarriers.includes(option.value),
                            }}
                            onChange={onChange('carriers')}
                        />
                    </WrapInput>
                </FormCol>

                <FormCol />
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
        price_label: {
            value: getStoreItem(state, 'price_label', ''),
            errors: getStoreItem(state, ['formErrors', 'price_label'], []),
        },
        price_month: {
            value: getStoreItem(state, 'price_month', ''),
            errors: getStoreItem(state, ['formErrors', 'price_month'], []),
        },
        price_additional: {
            value: getStoreItem(state, 'price_additional', ''),
            errors: getStoreItem(state, ['formErrors', 'price_additional'], []),
        },
        available_company: getStoreItem(state, 'available_company', ''),
        api: getStoreItem(state, 'api', []),
        pickup: getStoreItem(state, 'pickup', []),
        carriersOptions: getStoreItem(state, 'carriersOptions', []),
        carriers: getStoreItem(state, 'carriers', []),
        useCarriers: getStoreItem(state, 'useCarriers', []),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
        onChangeUseCarriers: getActionStore('onChangeUseCarriers'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
