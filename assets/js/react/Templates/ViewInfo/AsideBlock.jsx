import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const AsideBlock = ({ children, pref }) => (
    <div className={`form-info__profile-block form-info__profile-block_${pref}`}>{children}</div>
);

AsideBlock.propTypes = propTypes;

export default withTagDefaultProps(AsideBlock);
