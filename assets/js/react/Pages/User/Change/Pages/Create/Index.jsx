import React from 'react';
import PropTypes from 'prop-types';
import { url as _url } from 'Services';
import { withTagDefaultProps } from 'Hoc/Template';
import { PageTitle, BackLink } from 'Templates/Title';
import { Form, FormCol, FormFooter } from 'Templates/Form';
import { ask } from "Widgets/Modal";
import { BorderButton } from 'Templates/Button';
import { FormBlock, FormButtons } from '../../Views';

const propTypes = {
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const User = ({ t, service: { url } }) => {

    const onCancel = () => ask(
        'Cancel?',
        () => _url.redirect(`/${url}`)
    );

    return (
        <div className="main-content__block">
            <PageTitle title="Add New User" before={<BackLink url={`/${url}`} />} />
            <Form>
                <FormBlock />
                <FormFooter>
                    <FormCol>
                        <BorderButton onClick={onCancel} name="cancel">
                            {t('Cancel')}
                        </BorderButton>
                    </FormCol>
                    <FormButtons />
                </FormFooter>
            </Form>
        </div>
    );
};

User.propTypes = propTypes;

export default withTagDefaultProps(User);
