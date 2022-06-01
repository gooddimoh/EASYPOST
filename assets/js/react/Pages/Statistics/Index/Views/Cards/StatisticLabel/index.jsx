import React, {useMemo} from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { StatisticItem } from 'Templates/StatisticItem';
import { TableWidget } from 'Widgets/Table';
import CardTableHoc from '../CardTableHoc';

const propTypes = {
    total: PropTypes.arrayOf(PropTypes.any).isRequired,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.string)]).isRequired,
    onChange: PropTypes.func.isRequired,
    service: PropTypes.shape({
        divideTotal: PropTypes.func.isRequired,
    }).isRequired,
};

const StatisticLabel = ({ total, value, onChange, service: { divideTotal } }) => {
    const _total = useMemo(() => divideTotal(total), [total]);
    return (
        <StatisticItem title="Statistic Labels" data={_total} value={value} onChange={onChange}>
            <TableWidget />
        </StatisticItem>
    );
};

StatisticLabel.propTypes = propTypes;

export default compose(withTagDefaultProps, CardTableHoc)(StatisticLabel);
