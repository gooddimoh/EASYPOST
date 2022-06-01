import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, EasyCrop, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { companyTypeOptions } from 'Services/Enums';

const propTypes = {
    name: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    type: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    photo: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    onChange: PropTypes.func.isRequired,
};

const Block = ({ name, type, photo, onChange }) => {
    return (
        <FormBody>
            <FormRow>
                <FormTitle title="General Info" />
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="company" label="Your company name" errors={name.errors} required>
                        <Input value={name.value} onChange={onChange('name')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="typeCompany" label="Choose a type company" errors={type.errors} required>
                        <Input
                            type="select"
                            value={type.value}
                            inputProps={{ options: companyTypeOptions }}
                            onChange={onChange('type')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="photo">
                        <EasyCrop value={photo} onChange={onChange('photo')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
        </FormBody>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        name: {
            value: getStoreItem(state, 'name', ''),
            errors: getStoreItem(state, ['formErrors', 'name'], []),
        },
        type: {
            value: getStoreItem(state, 'type', ''),
            errors: getStoreItem(state, ['formErrors', 'type'], []),
        },
        photo: getStoreItem(state, 'photo', ''),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
