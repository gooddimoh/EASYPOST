import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { url as _url } from 'Services';
import { close } from 'Widgets/Modal';
import { Form, FormRow, FormTitle, FormDesc, FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';

const propTypes = {
    onResetForm: PropTypes.func.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
        kModal: PropTypes.string.isRequired,
    }).isRequired,
};

const Successfully = ({ onResetForm, service: { url, kModal }, t }) => {
    const onClose = () => {
        onResetForm();
        close(kModal);
    };

    const onRedirect = () => _url.redirect(`/${url}`);

    return (
        <>
            <Form>
                <FormRow>
                    <FormTitle title="Successfully !" />
                </FormRow>
                <FormRow>
                    <FormDesc title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard." />
                </FormRow>
                <FormFooter>
                    <BorderButton name="add-another" onClick={onClose}>
                        {t('Add another label')}
                    </BorderButton>
                    <BorderButton name="go-to-list" type="submit" onClick={onRedirect}>
                        {t('Go to labels list')}
                    </BorderButton>
                </FormFooter>
            </Form>
        </>
    );
};

Successfully.propTypes = propTypes;

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        onResetForm: getActionStore('onResetForm'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(Successfully);
