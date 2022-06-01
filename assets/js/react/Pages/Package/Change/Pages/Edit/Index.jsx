import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { BackLink, PageTitle } from 'Templates/Title';
import { ask } from "Widgets/Modal";
import { url as _url } from "Services";
import { Form } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { FormButtons, FormBlock } from '../../Views';

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
            <PageTitle title="Edit package" before={<BackLink url={`/${url}`} />} />

            <Form>
                <FormBlock />
                <div className="form__footer">
                    <div className="form__block">
                        <BorderButton onClick={onCancel} name="cancel">
                            {t('Cancel')}
                        </BorderButton>
                    </div>
                    <FormButtons edit />
                </div>
            </Form>
        </div>
    );
};

Company.propTypes = propTypes;



export default withTagDefaultProps(Company);
