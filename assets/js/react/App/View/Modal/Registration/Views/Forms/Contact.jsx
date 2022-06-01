import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, FormCol, WrapInput, WrapInputPhone } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { phoneList } from 'Services';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    data: PropTypes.shape({
        code: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
        phone: PropTypes.shape({
            value: PropTypes.string.isRequired,
            error: PropTypes.arrayOf(PropTypes.string).isRequired,
        }).isRequired,
    }).isRequired,
};

const Contact = ({ onChange, data }) => {
    const { code, phone } = data;
    return (
        <>
            <FormRow>
                <FormCol>
                    <WrapInputPhone>
                        <WrapInput name="code" label="Code" errors={code.error} required>
                            <Input
                                type="searchSelect"
                                value={code.value}
                                inputProps={{ options: phoneList }}
                                onChange={onChange('code')}
                            />
                        </WrapInput>
                        <WrapInput name="phone" label="Phone" errors={phone.error} required>
                            <Input value={phone.value} onChange={onChange('phone')} />
                        </WrapInput>
                    </WrapInputPhone>
                </FormCol>
            </FormRow>
        </>
    );
};

Contact.propTypes = propTypes;

export default withTagDefaultProps(Contact);
