import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { cond, isEmpty } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { addressTypeOptions } from 'Services/Enums';
import { FormCol, FormRow, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import MainAddressData from './MainAddressData';

const propTypes = {
    data: PropTypes.shape({
        id: PropTypes.string.isRequired,
        name: PropTypes.string.isRequired,
        type: PropTypes.string.isRequired,
        code: PropTypes.string.isRequired,
        phone: PropTypes.string.isRequired,
        email: PropTypes.string.isRequired,
        street1: PropTypes.string.isRequired,
        street2: PropTypes.string.isRequired,
        city: PropTypes.string.isRequired,
        zip: PropTypes.string.isRequired,
    }).isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    onChange: PropTypes.func.isRequired,
    request: PropTypes.func.isRequired,
    selectOptions: PropTypes.objectOf(PropTypes.any).isRequired,
};

const MainFormBlock = ({ data, errors, onChange, request, selectOptions }) => {
    const { id, name, type, code, phone, email, street1, street2, city, zip } = data;
    const _request = async (filterId) => {
        await request({ filter: { id: filterId } }, selectOptions.name);
    };
    const condition = cond([[(a) => !isEmpty(a), (b) => _request(b)]]);
    useEffect(() => condition(id), [id]);

    return (
        <>
            <FormRow>
                <FormCol>
                    <WrapInput name={selectOptions.name} label={selectOptions.label}>
                        <Input
                            type="asyncSelect"
                            inputProps={{ url: selectOptions.url }}
                            value={id}
                            onChange={onChange('id')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="name" label="Full Name" errors={errors.name} required>
                        <Input value={name} onChange={onChange('name')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="type" label="Type" errors={errors.type} required>
                        <Input
                            type="select"
                            inputProps={{ options: addressTypeOptions }}
                            value={type}
                            onChange={onChange('type')}
                        />
                    </WrapInput>
                </FormCol>
            </FormRow>

            <MainAddressData
                data={{ code, phone, email, street1, street2, city, zip }}
                errors={errors}
                onChange={onChange}
            />
        </>
    );
};

MainFormBlock.propTypes = propTypes;

export default withTagDefaultProps(MainFormBlock);
