import React from 'react';
import PropTypes from 'prop-types';
import { FormRow, FormTitle } from 'Templates/Form';
import { ButtonBlock, UserBlock } from './Templates';


const propTypes = {
    setSuccess: PropTypes.func.isRequired,
};

const Registration = ({ setSuccess }) => {
    return (
        <>
            <FormRow>
                <FormTitle title="User" />
            </FormRow>

            <UserBlock />

            <ButtonBlock setSuccess={setSuccess} />
        </>
    );
};

Registration.propTypes = propTypes;

export default Registration;