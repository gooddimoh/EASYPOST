import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    title: PropTypes.string.isRequired,
    pref: PropTypes.string.isRequired,
    before: PropTypes.node,
    after: PropTypes.node,
};

const defaultProps = {
    before: null,
    after: null,
};

const PageTitle = ({ title, pref, before, after, t }) => (
    <div className={`main-title main-title_${pref}`}>
        {before}
        <h1 className={`main-title__h1 main-title__h1_${pref}`}>{t(title)}</h1>
        {after}
    </div>
);

PageTitle.propTypes = propTypes;
PageTitle.defaultProps = defaultProps;

export default withTagDefaultProps(PageTitle);
