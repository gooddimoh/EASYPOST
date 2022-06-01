import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const RowLabel = ({ data, value, t }) => {
    const label = data.find((i) => i.value === value).label || '';
    return <span title={t(label)}>{t(label)}</span>;
};

RowLabel.propTypes = {
    data: PropTypes.arrayOf(PropTypes.any).isRequired,
    value: PropTypes.string.isRequired,
};

export default withTagDefaultProps(RowLabel);
