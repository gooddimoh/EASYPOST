import React, { useMemo } from 'react';
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
    service: PropTypes.shape({
        divideTotalValues: PropTypes.func.isRequired,
        divideGraphValues: PropTypes.func.isRequired,
        getTotalFromItems: PropTypes.func.isRequired,
    }).isRequired,
};

const Income = ({ graph, total, value, onChange, service }) => {
    const { divideGraphValues, divideTotalValues, getTotalFromItems } = service;
    const _total = useMemo(() => compose(getTotalFromItems, divideTotalValues)(total), [total]);
    const _graph = useMemo(() => divideGraphValues(graph), [graph]);
    return (
        <StatisticItem title="Incomes" data={_total} value={value} onChange={onChange}>
            <ChartWrapper data={_graph} />
        </StatisticItem>
    );
};

Income.propTypes = propTypes;

export default compose(withTagDefaultProps, CardHoc)(Income);
