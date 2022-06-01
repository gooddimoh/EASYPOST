import React from 'react';
import { pathOr } from 'ramda';
import { getString } from 'Services';

export const tableLabel = {
    name: 'Name',
    type: 'Type',
    phone: 'Phone number',
    email: 'Email',
    street1: 'Address 1',
    street2: 'Address 2',
    city: 'City',
    state: 'State',
    country: 'Country',
    zip: 'Zip code',
};

export const getLabel = (key) => {
    return pathOr(key, [key], tableLabel);
};

export const getTableRow = (key, obj) => {
    switch (key) {
        case 'phone':
            return (
                <div className="card-table__row">
                    <div className="card-table__col">
                        <span>{getLabel(key)}</span>
                    </div>
                    <div className="card-table__col">
                        <span>{`${getString(obj, 'code')}${getString(obj, key)}`}</span>
                    </div>
                </div>
            );

        default:
            return (
                <div className="card-table__row">
                    <div className="card-table__col">
                        <span>{getLabel(key)}</span>
                    </div>
                    <div className="card-table__col">
                        <span>{getString(obj, key)}</span>
                    </div>
                </div>
            );
    }
};
