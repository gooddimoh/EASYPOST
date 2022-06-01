import React, { useRef } from 'react';
import PropTypes from 'prop-types';
import { compose, toString } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { BackLink, PageTitle } from 'Templates/Title';
import { url as _url, getStringFromList } from 'Services';
import { labelTypeOptions } from 'Services/Enums';
import connect from 'Hoc/Template/Connect';
import { Form, FormCol, FormFooter } from 'Templates/Form';
import { ask } from 'Widgets/Modal';
import { BorderButton } from 'Templates/Button';
import { FormButtons } from '../../Views/FormBlocks';
import Index from '../../Views/SubPages/index';

const propTypes = {
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
    type: PropTypes.number.isRequired,
};

const Label = ({ t, type, service: { url } }) => {
    const _type = useRef(toString(type));

    const onCancel = () => ask('Cancel?', () => _url.redirect(`/${url}`));

    return (
        <div className="main-content__block">
            <PageTitle
                title={`Add new label (${getStringFromList(_type.current, labelTypeOptions)})`}
                before={<BackLink url={`/${url}`} />}
            />
            <Form>
                <Index type={_type.current} />
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

Label.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    type: getStoreItem(state, 'type', null),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, null))(Label);
