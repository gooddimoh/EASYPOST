import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    children: PropTypes.node.isRequired,
};

const CarrierCardItem = ({ children, pref }) => <li className={`carrier__item carrier__item_${pref}`}>{children}</li>;

CarrierCardItem.propTypes = propTypes;

export default withTagDefaultProps(CarrierCardItem);
