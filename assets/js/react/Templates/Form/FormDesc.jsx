import React from 'react';
import PropTypes from 'prop-types';
import { is } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    title: PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.string)]).isRequired,
};

const FormDesc = ({ pref, t, title }) => {
    return (
        <div className={`form__description form__description_${pref}`}>
            {is(Array, title) ? title.map((p, k) => <p key={`${p}-${k}`}>{t(p)}</p>) : t(title)}
        </div>
    );
};

FormDesc.propTypes = propTypes;

export default withTagDefaultProps(FormDesc);
