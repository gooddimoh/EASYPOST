import React from 'react';
import PropTypes from 'prop-types';
import {withTagDefaultProps} from 'Hoc/Template';

const propTypes = {
    text: PropTypes.string.isRequired,
    pref: PropTypes.string.isRequired,
};

const DefaultModal = ({ text, pref, t }) => (
    <div className={`modal__text modal__text_${pref}`}>
        <p>{t(text)}</p>
    </div>
);

DefaultModal.propTypes = propTypes;

export default withTagDefaultProps(DefaultModal);
