import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormCol, FormRow, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    length: PropTypes.string.isRequired,
    width: PropTypes.string.isRequired,
    height: PropTypes.string.isRequired,
    errors: PropTypes.objectOf(PropTypes.any).isRequired,
    onChange: PropTypes.func.isRequired,
};

const SizesOptions = ({ length, width, height, errors, onChange }) => {
    return (
        <FormRow>
            <FormCol>
                <WrapInput name="length" label="Length (inches)" errors={errors.length}>
                    <Input value={length} onChange={onChange(['parcel', 'length'])} />
                </WrapInput>
            </FormCol>
            <FormCol>
                <WrapInput name="width" label="Width (inches)" errors={errors.width}>
                    <Input value={width} onChange={onChange(['parcel', 'width'])} />
                </WrapInput>
            </FormCol>
            <FormCol>
                <WrapInput name="height" label="Height (inches)" errors={errors.height}>
                    <Input value={height} onChange={onChange(['parcel', 'height'])} />
                </WrapInput>
            </FormCol>
        </FormRow>
    );
};

SizesOptions.propTypes = propTypes;

export default withTagDefaultProps(SizesOptions);
