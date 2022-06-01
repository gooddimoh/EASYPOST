import React, { useEffect, useCallback, useRef } from 'react';
import { compose } from 'redux';
import connect from 'Hoc/Template/Connect';
import { debounce } from 'Services/Debounce';
import withTagDefaultProps from './DefaultProps';

const FetchItemProps =
    (Wrapped) =>
    ({ fetchItems, onFilterChange, request, load, forceUpdate, ...other }) => {
        const _request = useRef(request);

        useEffect(() => (_request.current = request), [request]);
        useEffect(() => (load ? debounce(() => fetchItems(_request.current), 500) : ''), [load]);
        useEffect(() => (forceUpdate ? fetchItems(_request.current) : ''), [forceUpdate]);

        const onPageClick = useCallback((page) => fetchItems({ ..._request.current, page }), []);
        const onPerPageChange = useCallback((size) => fetchItems({ ..._request.current, size }), []);

        const onSubmit = useCallback((e) => {
            e.preventDefault();
            fetchItems(_request.current);
        }, []);

        const onSortClick = useCallback((column) => {
            const asc = 'asc';
            const desc = 'desc';
            const newRequest = {
                ..._request.current,
                sort: {
                    direction: _request.current.sort.direction,
                    column,
                },
            };
            if (_request.current.sort.column === column) {
                newRequest.sort.direction = _request.current.sort.direction === asc ? desc : asc;
            } else {
                newRequest.sort.direction = asc;
            }

            fetchItems(newRequest);
        }, []);

        return (
            <Wrapped
                onSubmit={onSubmit}
                onSortClick={onSortClick}
                onPageClick={onPageClick}
                onPerPageChange={onPerPageChange}
                onFilterChange={onFilterChange}
                fetchItems={fetchItems}
                request={request}
                {...other}
            />
        );
    };

const mapStateToProps = (state, ownProps) => {
    const { getStoreItem } = ownProps.service;

    return {
        load: getStoreItem(state, 'request', false),
        forceUpdate: getStoreItem(state, 'forceUpdate', 0),
        items: getStoreItem(state, 'items', []),
        columns: getStoreItem(state, 'columns', []),
        pagination: getStoreItem(state, 'pagination', {}),
        request: {
            size: getStoreItem(state, ['pagination', 'per_page'], 50),
            filter: getStoreItem(state, 'filter', {}),
            sort: getStoreItem(state, 'sort', {}),
        },
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        fetchItems: getActionStore('fetchItems'),
        onFilterChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps), FetchItemProps);
