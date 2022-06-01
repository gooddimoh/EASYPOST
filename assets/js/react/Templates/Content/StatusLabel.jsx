import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const StatusLabel = ({ data, value, t }) => {
    const stringValue = value.toString();
    const result = data.find((i) => i.value.toString() === stringValue);
    return (
        <span title={t(result?.label || stringValue)} className={`status-label status-label_${result?.color || ''}`}>
            {t(result?.label || stringValue)}
        </span>
    );
};

StatusLabel.propTypes = {
    data: PropTypes.arrayOf(PropTypes.any).isRequired,
    value: PropTypes.number.isRequired,
};

export default withTagDefaultProps(StatusLabel);
