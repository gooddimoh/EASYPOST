import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormRow, FormCol, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {

    email: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string)
    }).isRequired,

    onChange: PropTypes.func.isRequired,
    t: PropTypes.func.isRequired,
};

const Block = ({ email, onChange, t }) => {
    return (
        <>
            <FormRow>
                <FormCol>
                    <WrapInput name="email" label="Your email" errors={email.errors} required>
                        <Input type="email" placeholder={t('Enter your email here')} value={email.value} onChange={onChange('email')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        email: {
            value: getStoreItem(state, 'email', ''),
            errors: getStoreItem(state, ['formErrors', 'email'], []),
        },
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {

    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
