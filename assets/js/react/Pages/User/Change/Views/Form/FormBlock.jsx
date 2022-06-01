import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, EasyCrop, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';
import { roleOptions, permissionsEnum } from 'Services/Enums';
import PermissionsProps from 'Hoc/Template/PermissionsProps';

const propTypes = {
    name: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    email: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    company: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    role: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    photo: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    isGranted: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired,
    isEdit: PropTypes.bool,
};

const defaultProps = {
    isEdit: false,
};

const Block = ({ name, email, company, photo, role, onChange, isGranted, isEdit }) => {
    const blockList = [];

    if (isGranted(permissionsEnum.owner, false, false)) {
        blockList.push(permissionsEnum.admin);
    }

    if (isGranted(permissionsEnum.manager, false, false)) {
        blockList.push(permissionsEnum.admin, permissionsEnum.owner);
    }

    const getRoleOptions = roleOptions.getListValues(blockList);

    return (
        <FormBody>
            <FormRow>
                <FormTitle title="General Info" />
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="name" label="Enter Your First & Last Name" errors={name.errors} required>
                        <Input value={name.value} onChange={onChange('name')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="email" label="Your email" errors={email.errors} required disabled={isEdit}>
                        <Input type="email" value={email.value} onChange={onChange('email')} />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="photo">
                        <EasyCrop value={photo} onChange={onChange('photo')} />
                    </WrapInput>
                </FormCol>
            </FormRow>
            <FormRow>
                <FormCol>
                    <WrapInput name="company" label="Company name" errors={company.errors} required disabled={isEdit}>
                        <Input
                            type="asyncSelect"
                            inputProps={{ url: '/companies/list' }}
                            value={company.value}
                            onChange={onChange('company')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol>
                    <WrapInput name="role" label="Role" errors={role.errors} required disabled={isEdit}>
                        <Input
                            type="select"
                            value={role.value}
                            inputProps={{ options: getRoleOptions }}
                            onChange={onChange('role')}
                        />
                    </WrapInput>
                </FormCol>
                <FormCol />
            </FormRow>
        </FormBody>
    );
};

Block.propTypes = propTypes;
Block.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        name: {
            value: getStoreItem(state, 'name', ''),
            errors: getStoreItem(state, ['formErrors', 'name'], []),
        },
        email: {
            value: getStoreItem(state, 'email', ''),
            errors: getStoreItem(state, ['formErrors', 'email'], []),
        },
        company: {
            value: getStoreItem(state, 'company', ''),
            errors: getStoreItem(state, ['formErrors', 'company'], []),
        },
        role: {
            value: getStoreItem(state, 'role', ''),
            errors: getStoreItem(state, ['formErrors', 'role'], []),
        },
        photo: getStoreItem(state, 'photo', ''),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(PermissionsProps, withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
