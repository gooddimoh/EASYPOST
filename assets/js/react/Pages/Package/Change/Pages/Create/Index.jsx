import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { BackLink, PageTitle } from 'Templates/Title';
import { url as _url } from 'Services';
import { BorderButton } from "Templates/Button";
import { Form, FormCol, FormFooter } from 'Templates/Form';
import { ask } from "Widgets/Modal";
import { FormBlock, FormButtons } from '../../Views';

const propTypes = {
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const Company = ({ t, service: { url } }) => {

    const onCancel = () => ask(
        'Cancel?',
        () => _url.redirect(`/${url}`)
    );

    return (
        <div className="main-content__block">
            <PageTitle title="Add New Package" before={ <BackLink url={ `/${ url }` }/> }/>
            <Form>
                <FormBlock/>
                <FormFooter>
                    <FormCol>
                        <BorderButton onClick={ onCancel } name="cancel">
                            { t('Cancel') }
                        </BorderButton>
                    </FormCol>
                    <FormButtons />
                </FormFooter>
            </Form>
        </div>
    );
};

Company.propTypes = propTypes;

export default withTagDefaultProps(Company);
