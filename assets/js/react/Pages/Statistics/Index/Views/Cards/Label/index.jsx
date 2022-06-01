import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { StatisticItem } from 'Templates/StatisticItem';
import { ChartWrapper } from 'Widgets/ChartWrapper';
import CardHoc from '../CardHoc';

const propTypes = {
    graph: PropTypes.objectOf(PropTypes.any).isRequired,
    total: PropTypes.arrayOf(PropTypes.any).isRequired,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.string)]).isRequired,
    onChange: PropTypes.func.isRequired,
};

const Label = ({ graph, total, value, onChange }) => (
    <StatisticItem title="Labels" data={total} value={value} onChange={onChange}>
        <ChartWrapper data={graph} />
    </StatisticItem>
);

Label.propTypes = propTypes;

export default compose(withTagDefaultProps, CardHoc)(Label);
