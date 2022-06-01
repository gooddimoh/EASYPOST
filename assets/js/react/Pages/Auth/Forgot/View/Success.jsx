import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';
import connect from 'Hoc/Template/Connect';

const Success = ({ email, t, pref }) => {
    return (
        <div className={`main-wrap main-wrap_${pref} auth`}>
            <div className={`auth__wrap auth__wrap_${pref}`}>
                <div className={`auth__logo auth__logo_${pref}`}>
                    <a href="/" className={`auth__logo-link auth__logo-link_${pref}`}>
                        <Img img="logo-pic-big" alt="logo" />
                    </a>
                </div>
                <div className={`auth__content auth__content_${pref}`}>
                    <h1 className={`auth__title auth__title_${pref}`}>{t('Success!')}</h1>
                    <div>
                        <div className={`auth__desc auth__desc_${pref} success`}>
                            {t('We’ve sent an email to ')}
                            <a href={`mailto:${email}`} className={`auth__desc-link auth__desc-link_${pref}`}>
                                {email}
                            </a>
                            {t(
                                ' with password reset instructions. If the email doesn’t show up soon, check your spam folder',
                            )}
                        </div>
                    </div>
                    <div>
                        <div className={`auth__link-wrap auth__link-wrap_${pref} success`}>
                            <a href="/login" className={`auth__form-forgot-link auth__form-forgot-link_${pref}`}>
                                {t('Return to login')}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

Success.propTypes = {
    email: PropTypes.string.isRequired,
};

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    email: getStoreItem(state, 'email'),
});

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        submitForm: getActionStore('submitFormAction'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Success);
