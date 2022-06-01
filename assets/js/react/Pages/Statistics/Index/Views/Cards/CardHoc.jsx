import React, { useState, useEffect } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { defaultRangeDays } from 'Services';

const CardHoc =
    (Wrapped) =>
    ({ submitAction, ...other }) => {
        const [value, onChange] = useState('');

        const onSubmit = async (filter) => {
            await submitAction(filter);
        };

        useEffect(() => {
            if (value.length === 2) {
                onSubmit(value);
            }
            if (value.length === 1) {
                onSubmit(defaultRangeDays());
            }
        }, [value]);

        /* eslint-disable-next-line react/jsx-props-no-spreading */
        return <Wrapped value={value} onChange={onChange} {...other} />;
    };

const mapStateToProps = (state, { service: { getStoreItem, serviceKey } }) => ({
    graph: getStoreItem(state, [serviceKey, 'graph'], {}),
    total: getStoreItem(state, [serviceKey, 'total', 'items'], []),
    columns: getStoreItem(state, [serviceKey, 'columns'], []),
    pagination: getStoreItem(state, [serviceKey, 'pagination'], {}),
    items: getStoreItem(state, [serviceKey, 'items'], []),
});

const mapDispatchToProps = ({ service: { getActionStore } }) => ({
    submitAction: getActionStore('submitFilterAction'),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps), CardHoc);
