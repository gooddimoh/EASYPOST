import React, { useRef } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { sha1, url as _url } from 'Services';
import { FormCol } from 'Templates/Form';
import { ButtonsWrap, BorderButton } from 'Templates/Button';
import { NotificationWrap } from 'Widgets/NotificationWrap';

const propTypes = {
    news: PropTypes.shape({
        id: PropTypes.string,
        title: PropTypes.string.isRequired,
        link: PropTypes.string.isRequired,
        description: PropTypes.string.isRequired,
        photo: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    }),
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
    submitForm: PropTypes.func.isRequired,
    onResetForm: PropTypes.func.isRequired,
    validateForm: PropTypes.func.isRequired,
    edit: PropTypes.bool,
};

const defaultProps = {
    news: {
        id: '',
    },
    edit: false,
};

const Buttons = ({ news, t, submitForm, onResetForm, edit, validateForm, service: { url } }) => {
    const oldFormHash = useRef(sha1(news));
    const isFormChanged = oldFormHash.current !== sha1(news);

    const submitRequest = async (cb) => {
        const { id } = await submitForm(news, news.id);
        if (id) {
            cb(id);
        }
    };

    const onSubmitAnother = async () => {
        validateForm(news, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'News saved' });
                onResetForm();
            });
        });
    };

    const onSubmit = async () => {
        validateForm(news, () => {
            submitRequest(() => {
                NotificationWrap({ title: 'Success!', text: 'News saved' });
                _url.redirect(`/${url}`);
            });
        });
    };

    return (
        <FormCol>
            <ButtonsWrap>
                {!edit && (
                    <BorderButton onClick={onSubmitAnother} name="save-add-another" disabled={!isFormChanged}>
                        {t('Save & Add Another')}
                    </BorderButton>
                )}
                <BorderButton onClick={onSubmit} name="save" disabled={!isFormChanged}>
                    {t('Save')}
                </BorderButton>
            </ButtonsWrap>
        </FormCol>
    );
};

Buttons.propTypes = propTypes;
Buttons.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        news: {
            id: getStoreItem(state, 'id', ''),
            title: getStoreItem(state, 'title', ''),
            description: getStoreItem(state, 'description', ''),
            link: getStoreItem(state, 'link', ''),
            photo: getStoreItem(state, 'photo', ''),
        },
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        submitForm: getActionStore('submitFormAction'),
        onResetForm: getActionStore('onResetForm'),
        validateForm: getActionStore('validateForm'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Buttons);
