import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    title: PropTypes.string,
};

const defaultProps = {
    title: '',
};

const AsideTitle = ({ title, pref }) => (
    <div className={`form-info__profile-name form-info__profile-name_${pref}`}>{title}</div>
);

AsideTitle.propTypes = propTypes;
AsideTitle.defaultProps = defaultProps;

export default withTagDefaultProps(AsideTitle);
