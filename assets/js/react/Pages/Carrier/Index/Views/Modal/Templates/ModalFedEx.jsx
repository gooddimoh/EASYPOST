import React, {useEffect} from 'react';
import {compose, cond, isEmpty, not} from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';
import { FormBody, FormCol, FormRow, WrapInput } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    item: PropTypes.objectOf(PropTypes.any).isRequired,
    state: PropTypes.objectOf(PropTypes.string).isRequired,
    setState: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired
};

const ModalFedEx = ({ item, state, setState, onChange }) => {
    const { credentials } = item;
    const { account_number, meter_number, key, password, errors } = state;

    useEffect(() => cond([[compose(not, isEmpty), setState]])(credentials), []);

    return (
        <FormBody>
            <FormRow>
                <FormCol>
                    <WrapInput name="account_number" label="Account number" errors={errors?.account_number} required>
                        <Input value={account_number} onChange={onChange('account_number')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="meter_number" label="Meter number" errors={errors?.meter_number} required>
                        <Input value={meter_number} onChange={onChange('meter_number')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="key" label="Key" errors={errors?.key} required>
                        <Input value={key} onChange={onChange('key')} />
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

ModalFedEx.propTypes = propTypes;

export default compose(withTagDefaultProps)(ModalFedEx);
