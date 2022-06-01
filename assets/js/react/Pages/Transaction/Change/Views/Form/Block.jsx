import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    balance: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    company: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    description: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    onChange: PropTypes.func.isRequired,
};

const Block = ({ balance, company, description, onChange }) => {
    return (
        <FormBody>
            <FormRow>
                <FormTitle title="General Info" />
            </FormRow>

            <FormRow>
                <FormCol columnSize={4} fromColumns={12}>
                    <FormRow>
                        <WrapInput name="balance" label="Balance" errors={balance.errors} required>
                            <Input value={balance.value} onChange={onChange('balance')} />
                        </WrapInput>
                    </FormRow>
                    <FormRow>
                        <WrapInput name="company" label="Company" errors={company.errors} required>
                            <Input
                                type="asyncSelect"
                                inputProps={{ url: '/companies/list' }}
                                value={company.value}
                                onChange={onChange('company')}
                            />
                        </WrapInput>
                    </FormRow>
                </FormCol>
                <FormCol columnSize={8} fromColumns={12}>
                    <WrapInput name="description" label="Description" errors={description.errors} required>
                        <Input
                            type="textarea"
                            name="description"
                            value={description.value}
                            onChange={onChange('description')}
                        />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </FormBody>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        balance: {
            value: getStoreItem(state, 'balance', ''),
            errors: getStoreItem(state, ['formErrors', 'balance'], []),
        },
        company: {
            value: getStoreItem(state, 'company', ''),
            errors: getStoreItem(state, ['formErrors', 'company'], []),
        },
        description: {
            value: getStoreItem(state, 'description', ''),
            errors: getStoreItem(state, ['formErrors', 'description'], []),
        },
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
