import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';
import { cond, equals } from 'ramda';
import { Img } from 'Templates/Img';
import { Label } from './Template';

const propTypes = {
    type: PropTypes.string.isRequired,
    flagLabel: PropTypes.bool.isRequired,
    t: PropTypes.func.isRequired,
};

const Header = ({ type, flagLabel, t, pref }) => {
    const imagesCarriers = cond([
        [
            equals('UpsAccount'),
            () => <Img className={`carrier-card__img carrier-card__img_${pref}`} img="ups-logo" alt={t('ups logo')} />,
        ],
        [
            equals('FedexAccount'),
            () => (
                <Img className={`carrier-card__img carrier-card__img_${pref}`} img="fedex-logo" alt={t('fedex logo')} />
            ),
        ],
        [
            equals('UspsAccount'),
            () => (
                <Img className={`carrier-card__img carrier-card__img_${pref}`} img="usps-logo" alt={t('usps logo')} />
            ),
        ],
    ]);

    return (
        <div className={`carrier-card__header carrier-card__header_${pref}`}>
            <Label flagLabel={flagLabel} />
            <div className={`carrier-card__block carrier-card__block_${pref}`}>{imagesCarriers(type)}</div>
        </div>
    );
};

Header.propTypes = propTypes;

export default withTagDefaultProps(Header);
