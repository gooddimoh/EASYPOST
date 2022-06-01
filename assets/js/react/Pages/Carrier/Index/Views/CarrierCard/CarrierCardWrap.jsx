import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';

const propTypes = {
    children: PropTypes.node.isRequired,
};

const CarrierCardWrap = ({ children, pref }) => {
    return (
        <div className={`carrier carrier_${pref}`}>
            <ul className={`carrier__list carrier__list_${pref}`}>
                {children}
            </ul>
        </div>
    );
};

CarrierCardWrap.propTypes = propTypes;

export default withTagDefaultProps(CarrierCardWrap);