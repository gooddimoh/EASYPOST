import React, { useRef } from 'react';
import PropTypes from 'prop-types';
import { compose, toString } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { BackLink, PageTitle } from 'Templates/Title';
import { url as _url, getStringFromList } from 'Services';
import { labelTypeOptions } from 'Services/Enums';
import { ask } from 'Widgets/Modal';
import connect from 'Hoc/Template/Connect';
import { Form, FormCol, FormFooter } from 'Templates/Form';
import { BorderButton } from 'Templates/Button';
import { FormButtons } from '../../Views/FormBlocks';
import Index from '../../Views/SubPages/index';

const propTypes = {
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
    type: PropTypes.string.isRequired,
    activePackage: PropTypes.string,
    userId: PropTypes.string.isRequired,
};

const defaultProps = {
    activePackage: '',
};

const Label = ({ t, type, activePackage, userId, service: { url } }) => {
    const _type = useRef(type);

    const onCancel = () => ask('Cancel?', () => _url.redirect(`/${url}`));
    const onChoosePackage = () => _url.redirect(`/users/${userId}/?tab=package`);

    return (
        <div className="main-content__block">
            <PageTitle
                title={`Create new label (${getStringFromList(_type.current, labelTypeOptions)})`}
                before={<BackLink url={`/${url}`} />}
            />
            {!activePackage && (
                <div className="info-line" onClick={onChoosePackage} onKeyDown={onChoosePackage}>
                    <span>{t('To create a label, first select a package')}</span>
                </div>
            )}
            <fieldset disabled={!activePackage}>
                <Form>
                    <Index type={_type.current} />
                    <FormFooter>
                        <FormCol>
                            <BorderButton onClick={onCancel} name="cancel">
                                {t('Cancel')}
                            </BorderButton>
                        </FormCol>
                        <FormCol>
                            <FormButtons />
                        </FormCol>
                    </FormFooter>
                </Form>
            </fieldset>
        </div>
    );
};

Label.propTypes = propTypes;
Label.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    activePackage: state.userState.activePackage,
    userId: state.userState.id,
    type: toString(getStoreItem(state, 'type', null)),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, null))(Label);
