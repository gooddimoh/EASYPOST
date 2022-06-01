import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { getStringFromList, url as _url } from 'Services';
import { addressBookTypeOptions } from 'Services/Enums';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { ask } from 'Widgets/Modal';
import { BackLink, PageTitle } from 'Templates/Title';
import { Form, FormFooter, FormCol } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { FormBlock, FormButtons } from '../../Views';

const propTypes = {
    type: PropTypes.number.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const User = ({ type, t, service: { url } }) => {
    const onCancel = () => ask('Cancel?', () => _url.redirect(`/${url}`));

    return (
        <div className="main-content__block">
            <PageTitle
                title={`Add New ${getStringFromList(type, addressBookTypeOptions)}`}
                before={<BackLink url={`/${url}`} />}
            />
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

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        type: getStoreItem(state, 'type', 0),
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        submitForm: getActionStore('submitFormAction'),
        onResetForm: getActionStore('onResetForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(User);
