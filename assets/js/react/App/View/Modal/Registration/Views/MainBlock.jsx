import React, { useEffect } from 'react';
import { compose, toString } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { Form, FormBody, FormRow, FormTitle, FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { User, Company, Address, Contact } from './Forms';

const propTypes = {
    onClose: PropTypes.func.isRequired,
    onSuccess: PropTypes.func.isRequired,
    onSubmitForm: PropTypes.func.isRequired,
    preFill: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    form: PropTypes.objectOf(PropTypes.any).isRequired,
    userName: PropTypes.string.isRequired,
    userEmail: PropTypes.string.isRequired,
    companyType: PropTypes.string.isRequired,
    companyName: PropTypes.string,
    service: PropTypes.shape({
        validateFormData: PropTypes.func.isRequired,
    }).isRequired,
};

const defaultProps = {
    companyName: '',
};

const MainBlock = ({
    t,
    onClose,
    onSuccess,
    form,
    userName,
    userEmail,
    companyType,
    companyName,
    onSubmitForm,
    preFill,
    onChange,
    validateForm,
    service: { validateFormData },
}) => {
    const { name, email, company, type, street1, typeAddress, country, state, city, zip, code, phone } = form;

    useEffect(() => {
        preFill({
            name: userName,
            email: userEmail,
            type: companyType,
            company: companyName,
        });
    }, []);

    const onSubmit = () => {
        validateForm(validateFormData(form), async () => {
            const res = await onSubmitForm(form);
            if (res) {
                onClose();
                onSuccess();
            }
        });
    };

    return (
        <Form>
            <FormBody>
                <FormRow>
                    <FormTitle title="User" />
                </FormRow>
                <User onChange={onChange} data={{ name, email }} />

                <FormRow>
                    <FormTitle title="Company" />
                </FormRow>
                <Company onChange={onChange} data={{ company, type }} />

                <FormRow>
                    <FormTitle title="Address" />
                </FormRow>
                <Address onChange={onChange} data={{ street1, typeAddress, country, state, city, zip }} />

                <FormRow>
                    <FormTitle title="Contact info" />
                </FormRow>
                <Contact onChange={onChange} data={{ code, phone }} />
            </FormBody>
            <FormFooter>
                <BorderButton name="cancel" onClick={onClose}>
                    {t('Cancel')}
                </BorderButton>
                <BorderButton name="Save" type="submit" onClick={onSubmit}>
                    {t('Save')}
                </BorderButton>
            </FormFooter>
        </Form>
    );
};

MainBlock.propTypes = propTypes;
MainBlock.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { formatStoreItem } }) => {
    return {
        form: {
            ...formatStoreItem('name', state),
            ...formatStoreItem('email', state),
            ...formatStoreItem('company', state),
            ...formatStoreItem('type', state),
            ...formatStoreItem('street1', state),
            ...formatStoreItem('typeAddress', state),
            ...formatStoreItem('country', state),
            ...formatStoreItem('state', state),
            ...formatStoreItem('city', state),
            ...formatStoreItem('zip', state),
            ...formatStoreItem('code', state),
            ...formatStoreItem('phone', state),
        },
        userName: state.userState.fullName,
        userEmail: state.userState.email,
        companyType: toString(state.userState.companyType),
        companyName: state.userState.companyName,
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onSubmitForm: getActionStore('onSubmitForm'),
        preFill: getActionStore('preFill'),
        onChange: getActionStore('onChange'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
