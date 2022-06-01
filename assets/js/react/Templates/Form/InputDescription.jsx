import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    text: PropTypes.string.isRequired,
};

const InputDescription = ({ pref, text, t }) => (
    <div className={`input-description input-description_${pref}`}>{t(text)}</div>
);

InputDescription.propTypes = propTypes;

export default withTagDefaultProps(InputDescription);
