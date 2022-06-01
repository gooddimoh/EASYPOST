import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    data: PropTypes.shape({
        name: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        email: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
    }).isRequired,
};

const User = ({ onChange, data }) => {
    const { name, email } = data;
    return (
        <>
            <FormRow>
                <WrapInput name="name" label="Enter Your First & Last Name" errors={name.error} required>
                    <Input value={name.value} placeholder="Enter Your First & Last Name" onChange={onChange('name')} />
                </WrapInput>
            </FormRow>
            <FormRow>
                <WrapInput name="email" label="Your email" errors={email.error} required>
                    <Input
                        type="email"
                        placeholder="Enter your email here"
                        value={email.value}
                        onChange={onChange('email')}
                        inputProps={{ readOnly: true }}
                    />
                </WrapInput>
            </FormRow>
        </>
    );
};

User.propTypes = propTypes;

export default withTagDefaultProps(User);
