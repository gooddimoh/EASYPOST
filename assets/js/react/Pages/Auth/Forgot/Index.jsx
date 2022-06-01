import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import Success from './View/Success';
import Forgot from './View/Forgot';

const Index = ({ status }) => <>{status === 'success' ? <Success /> : <Forgot />}</>;

Index.propTypes = {
    status: PropTypes.string.isRequired,
};

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    status: getStoreItem(state, 'status'),
});

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;
    return {
        submitForm: getActionStore('submitFormAction'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Index);
