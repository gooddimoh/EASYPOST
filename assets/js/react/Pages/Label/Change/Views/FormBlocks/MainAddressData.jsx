import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { phoneList } from 'Services';
import { FormCol, FormRow, WrapInput, WrapInputPhone } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    data: PropTypes.shape({
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
};

const MainAddressData = ({ data, errors, onChange }) => {
    const { code, phone, email, street1, street2, city, zip } = data;

    return (
        <>
            <FormRow>
                <FormCol>
                    <WrapInput name="email" label="Email" errors={errors.email} required>
                        <Input value={email} onChange={onChange('email')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInputPhone>
                        <WrapInput name="code" label="Phone Code" errors={errors.code} required>
                            <Input
                                type="searchSelect"
                                value={code}
                                inputProps={{ options: phoneList }}
                                onChange={onChange('code')}
                            />
                        </WrapInput>
                        <WrapInput name="phone" label="Phone Number" errors={errors.phone} required>
                            <Input value={phone} onChange={onChange('phone')} />
                        </WrapInput>
                    </WrapInputPhone>
                </FormCol>
                <FormCol>
                    <WrapInput name="street1" label="Address 1" errors={errors.street1} required>
                        <Input value={street1} onChange={onChange('street1')} />
                    </WrapInput>
                </FormCol>
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="street2" label="Address 2" errors={errors.street2}>
                        <Input value={street2} onChange={onChange('street2')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="city" label="City" errors={errors.city} required>
                        <Input value={city} onChange={onChange('city')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="zip" label="Zip Code" errors={errors.zip} required>
                        <Input value={zip} onChange={onChange('zip')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </>
    );
};

MainAddressData.propTypes = propTypes;

export default withTagDefaultProps(MainAddressData);
