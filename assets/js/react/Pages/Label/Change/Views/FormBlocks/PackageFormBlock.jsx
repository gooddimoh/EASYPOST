import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { curry, compose, not, isEmpty, cond } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormBody, FormCol, FormRow, FormTitle, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { BorderButton, IconButton } from 'Templates/Button';

const propTypes = {
    packages: PropTypes.arrayOf(PropTypes.any).isRequired,
    errors: PropTypes.arrayOf(PropTypes.any).isRequired,
    onChange: PropTypes.func.isRequired,
    addItem: PropTypes.func.isRequired,
    deleteItem: PropTypes.func.isRequired,
    onCalculateOptions: PropTypes.func.isRequired,
    service: PropTypes.shape({
        newItemTemplate: PropTypes.func.isRequired,
        calcWholeOption: PropTypes.func.isRequired,
    }).isRequired,
    t: PropTypes.func.isRequired,
};

const PackageFormBlock = ({ packages, errors, onChange, addItem, deleteItem, onCalculateOptions, service, t }) => {
    const { newItemTemplate, calcWholeOption } = service;
    const _onChange = curry((key, id, value) => onChange(key, id, value));

    useEffect(() => {
        cond([[compose(not, isEmpty), compose(onCalculateOptions, calcWholeOption)]])(packages);
    }, [packages]);

    return (
        <FormBody>
            <FormRow>
                <FormTitle title="What's in package?" />
            </FormRow>

            <FormRow>
                <BorderButton name="add-item" onClick={() => addItem(newItemTemplate())}>
                    {t('Add items to declaration!')}
                </BorderButton>
            </FormRow>

            {packages.map(({ _id, id, description, quantity, weight, price }, k) => {
                return (
                    <FormRow key={_id || id}>
                        <FormCol>
                            <WrapInput
                                name="description"
                                label="Product description"
                                errors={errors[k]?.description}
                                required
                            >
                                <Input value={description} onChange={_onChange('description', _id)} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput name="quantity" label="Item quantity" errors={errors[k]?.quantity} required>
                                <Input value={quantity} onChange={_onChange('quantity', _id)} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput
                                name="weight"
                                label="Item weight"
                                description="Item quantity * per weight in pounds"
                                errors={errors[k]?.weight}
                                required
                            >
                                <Input value={weight} onChange={_onChange('weight', _id)} />
                            </WrapInput>
                        </FormCol>
                        <FormCol>
                            <WrapInput
                                name="price"
                                label="Item price"
                                description="Quantity of goods * per price of one"
                                errors={errors[k]?.price}
                                required
                            >
                                <Input value={price} onChange={_onChange('price', _id)} />
                            </WrapInput>
                        </FormCol>
                        <IconButton title="Delete item" icon="icon_delete" onClick={() => deleteItem(_id)} />
                    </FormRow>
                );
            })}
        </FormBody>
    );
};

PackageFormBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        packages: getStoreItem(state, 'packages', []),
        errors: getStoreItem(state, ['formErrors', 'packages'], []),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChangePackage'),
        addItem: getActionStore('addItem'),
        deleteItem: getActionStore('deleteItem'),
        onCalculateOptions: getActionStore('onCalculateOptions'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(PackageFormBlock);
