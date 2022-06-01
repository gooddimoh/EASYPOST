import React, { useState, useEffect } from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { defaultRangeDays } from 'Services';

const CardTableHoc =
    (Wrapped) =>
        ({ submitAction, onChangeAction, ...other }) => {
            const [value, onChange] = useState('');

            const onSubmit = async (filter) => {
                await submitAction(filter);
                await onChangeAction('date_from', filter[0]);
                await onChangeAction('date_to', filter[1]);
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

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    columns: getStoreItem(state, 'columns', []),
    pagination: getStoreItem(state, 'pagination', {}),
    items: getStoreItem(state, 'items', []),
    total: getStoreItem(state, ['total', 'items'], []),
});

const mapDispatchToProps = ({ service: { getActionStore } }) => ({
    submitAction: getActionStore('submitFilterAction'),
    onChangeAction: getActionStore('onChange'),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps), CardTableHoc);