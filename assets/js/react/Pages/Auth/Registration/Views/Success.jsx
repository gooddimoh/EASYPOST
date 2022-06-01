import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

const propTypes = {
    pref: PropTypes.string.isRequired,
};

const Success = ({ pref, t }) => {
    return (
        <div className={`auth__block-logo auth__block_${pref}`}>
            <a href="/" className={`auth__logo-link auth__logo-link_${pref}`}>
                <Img img="logo" alt="logo" />
            </a>
            <div className={`auth__text auth__text_${pref}`}>{t('Thank for registration')}</div>
        </div>
    );
};

Success.propTypes = propTypes;

export default withTagDefaultProps(Success);