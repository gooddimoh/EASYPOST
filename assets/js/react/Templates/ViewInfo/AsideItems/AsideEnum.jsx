import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { RowLabel } from 'Templates/Content';

const propTypes = {
    options: PropTypes.arrayOf(PropTypes.any).isRequired,
    value: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
};

const AsideEnum = ({ options, value, title, t }) => {
    return (
        <>
            <span className="form-info__profile-label">{t(title)}</span>
            <RowLabel data={options} value={value} />
        </>
    );
};

AsideEnum.propTypes = propTypes;

export default withTagDefaultProps(AsideEnum);
