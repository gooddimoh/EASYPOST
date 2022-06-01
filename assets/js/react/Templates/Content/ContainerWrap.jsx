import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const ContainerWrap = ({ pref, children }) => (
    <div className={`main-content__wrap main-content__wrap_${pref}`}>{children}</div>
);

ContainerWrap.propTypes = {
    pref: PropTypes.string.isRequired,
};

export default withTagDefaultProps(ContainerWrap);
