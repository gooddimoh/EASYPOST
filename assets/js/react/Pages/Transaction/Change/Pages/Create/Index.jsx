import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { BackLink, PageTitle } from 'Templates/Title';
import { url as _url } from 'Services';
import { ask } from 'Widgets/Modal';
import { Form, FormCol, FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { FormBlock, FormButtons } from '../../Views';

const propTypes = {
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const Transaction = ({ t, service: { url } }) => {
    const onCancel = () => ask('Cancel?', () => _url.redirect(`/${url}`));

    return (
        <div className="main-content__block">
            <PageTitle title="Add New Transaction" before={<BackLink url={`/${url}`} />} />
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

Transaction.propTypes = propTypes;

export default withTagDefaultProps(Transaction);
