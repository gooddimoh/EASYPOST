import React from 'react';
import PropTypes from 'prop-types';
import { compose, equals } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { Input } from 'Templates/Input';

const propTypes = {
    item: PropTypes.shape({
        id: PropTypes.string.isRequired,
        service_type: PropTypes.string.isRequired,
    }).isRequired,
    rateId: PropTypes.string.isRequired,
    onChangeRate: PropTypes.func.isRequired,
};

const ServiceTypeRow = ({ item, rateId, onChangeRate }) => {
    const { id, service_type } = item;

    return (
        <Input
            type="radio"
            name={id}
            value={id}
            checked={equals(rateId, id)}
            onChange={() => onChangeRate(id)}
            inputProps={{ label: service_type }}
        />
    );
};

ServiceTypeRow.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        rateId: getStoreItem(state, 'rateId', ''),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChangeRate: getActionStore('onChangeRate'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(ServiceTypeRow);
