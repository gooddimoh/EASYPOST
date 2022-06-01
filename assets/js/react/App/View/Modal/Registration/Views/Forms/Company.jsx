import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { companyTypeOptions } from 'Services/Enums';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    data: PropTypes.shape({
        company: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        type: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
    }).isRequired,
};

const Company = ({ onChange, data }) => {
    const { company, type } = data;
    return (
        <>
            <FormRow>
                <WrapInput name="company" label="Your company name" errors={company.error} required>
                    <Input value={company.value} placeholder="Type your company" onChange={onChange('company')} />
                </WrapInput>
            </FormRow>
            <FormRow>
                <WrapInput name="type" label="Choose a type company" required>
                    <Input
                        type="select"
                        value={type.value}
                        inputProps={{ options: companyTypeOptions }}
                        onChange={onChange('type')}
                    />
                </WrapInput>
            </FormRow>
        </>
    );
};

Company.propTypes = propTypes;

export default withTagDefaultProps(Company);
