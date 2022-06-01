import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';
import PermissionsProps from 'Hoc/Template/PermissionsProps';

const propTypes = {
    oldPassword: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    password: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    passwordRepeat: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    onChange: PropTypes.func.isRequired,
};

const Block = ({ oldPassword, password, passwordRepeat, onChange }) => {
    return (
        <FormBody>
            <FormRow>
                <FormTitle title="General Info" />
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="oldPassword" label="Old password" errors={oldPassword.errors} required>
                        <Input value={oldPassword.value} type="password" onChange={onChange('oldPassword')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="password" label="New password" errors={password.errors} required>
                        <Input value={password.value} type="password" onChange={onChange('password')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput
                        name="passwordRepeat"
                        label="Repeat new password"
                        errors={passwordRepeat.errors}
                        required
                    >
                        <Input value={passwordRepeat.value} type="password" onChange={onChange('passwordRepeat')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </FormBody>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        oldPassword: {
            value: getStoreItem(state, 'oldPassword', ''),
            errors: getStoreItem(state, ['formErrors', 'oldPassword'], []),
        },
        password: {
            value: getStoreItem(state, 'password', ''),
            errors: getStoreItem(state, ['formErrors', 'password'], []),
        },
        passwordRepeat: {
            value: getStoreItem(state, 'passwordRepeat', ''),
            errors: getStoreItem(state, ['formErrors', 'passwordRepeat'], []),
        },
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(PermissionsProps, withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
