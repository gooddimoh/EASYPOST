import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { isEmpty, cond, compose, not } from 'ramda';
import { FormBody, FormCol, FormRow, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    item: PropTypes.objectOf(PropTypes.any).isRequired,
    state: PropTypes.objectOf(PropTypes.string).isRequired,
    setState: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired
};

const ModalUPS = ({ item, state, setState, onChange }) => {
    const { credentials } = item;
    const {access_license_number, account_number, user_id, password, errors} = state;

    useEffect(() => cond([[compose(not, isEmpty), setState]])(credentials), []);

    return (
        <FormBody>
            <FormRow>
                <FormCol>
                    <WrapInput name="access_license_number" label="Access license number" errors={errors?.access_license_number} required>
                        <Input
                            value={access_license_number}
                            onChange={onChange('access_license_number')}
                        />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="account_number" label="Account number" errors={errors?.account_number} required>
                        <Input value={account_number} onChange={onChange('account_number')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="user_id" label="User id" errors={errors?.user_id} required>
                        <Input value={user_id} onChange={onChange('user_id')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="password" label="Password" errors={errors?.password} required>
                        <Input type="password" value={password} onChange={onChange('password')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </FormBody>
    );
};

ModalUPS.propTypes = propTypes;

export default ModalUPS;
