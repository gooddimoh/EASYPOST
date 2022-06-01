import React from 'react';
import PropTypes from 'prop-types';
import { curry, compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps, CheckPermission } from 'Hoc/Template';
import { FormBody, FormCol, FormRow, FormTitle, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { permissionsEnum } from 'Services/Enums';
import SizesOptions from './SizesOptions';

const propTypes = {
    weight: PropTypes.string.isRequired,
    length: PropTypes.string.isRequired,
    width: PropTypes.string.isRequired,
    height: PropTypes.string.isRequired,
    price: PropTypes.string.isRequired,
    pickup: PropTypes.arrayOf(PropTypes.string).isRequired,
    onChange: PropTypes.func.isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
};

const OptionsWorldForm = ({ weight, length, width, height, price, pickup, onChange, errors }) => {
    const _onChange = curry((key, value) => onChange(key, value));

    return (
        <FormBody>
            <FormRow>
                <FormTitle title="Additional options" />
            </FormRow>
            <SizesOptions length={length} width={width} height={height} errors={errors} onChange={_onChange} />
            <FormRow>
                <FormCol>
                    <WrapInput name="weight" label="Whole Weight (lbs)" errors={errors.weight} required>
                        <Input value={weight} onChange={_onChange('weight')} inputProps={{ readOnly: true }} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="price" label="Whole Price" errors={errors.price} required>
                        <Input value={price} onChange={_onChange('price')} inputProps={{ readOnly: true }} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <CheckPermission allowedPermissions={[permissionsEnum.pickup]}>
                        <WrapInput name="pickup" label="Need Pickup">
                            <Input
                                type="checkbox"
                                value={pickup}
                                inputProps={{
                                    options: [{ value: 'pickup', label: 'Pickup' }],
                                }}
                                onChange={_onChange('pickup')}
                            />
                        </WrapInput>
                    </CheckPermission>
                </FormCol>
            </FormRow>
        </FormBody>
    );
};

OptionsWorldForm.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        price: getStoreItem(state, 'price', ''),
        weight: getStoreItem(state, 'weight', ''),
        length: getStoreItem(state, ['parcel', 'length'], ''),
        width: getStoreItem(state, ['parcel', 'width'], ''),
        height: getStoreItem(state, ['parcel', 'height'], ''),
        pickup: getStoreItem(state, 'pickup', []),
        errors: {
            price: getStoreItem(state, ['formErrors', 'price'], []),
            weight: getStoreItem(state, ['formErrors', 'weight'], []),
            length: getStoreItem(state, ['formErrors', 'parcel', 'length'], []),
            width: getStoreItem(state, ['formErrors', 'parcel', 'width'], []),
            height: getStoreItem(state, ['formErrors', 'parcel', 'height'], []),
        },
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(OptionsWorldForm);
