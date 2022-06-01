import React from 'react';
import {withTagDefaultProps} from 'Hoc/Template';
import PropTypes from 'prop-types';

const propTypes = {
    title: PropTypes.string.isRequired,
    text: PropTypes.string.isRequired,
    t: PropTypes.func.isRequired,
};

const Body = ({ title, text, t, pref }) => {
    return (
        <div className={`carrier-card__body carrier-card__body_${pref}`}>
            <div className={`carrier-card__title carrier-card__title_${pref}`}>{t(title)}</div>
            <ul className={`carrier-card__list carrier-card__list_${pref}`}>
                <li className={`carrier-card__text carrier-card__text_${pref}`}>{t(text)}</li>
            </ul>
        </div>
    );
};

Body.propTypes = propTypes;

export default withTagDefaultProps(Body);
