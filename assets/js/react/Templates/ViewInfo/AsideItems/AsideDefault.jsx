import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    value: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
};

const AsideDefault = ({ value, title, t }) => {
    return (
        <>
            <span className="form-info__profile-label">{t(title)}</span>
            <span className="form-info__profile-value">{value}</span>
        </>
    );
};

AsideDefault.propTypes = propTypes;

export default withTagDefaultProps(AsideDefault);
