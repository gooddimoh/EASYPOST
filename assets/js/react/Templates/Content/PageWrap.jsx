import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const PageWrap = ({ pref, children }) => (
    <div className={`page-wrap page-wrap_${pref}`}>{children}</div>
);

PageWrap.propTypes = {
    pref: PropTypes.string.isRequired,
};

export default withTagDefaultProps(PageWrap);
