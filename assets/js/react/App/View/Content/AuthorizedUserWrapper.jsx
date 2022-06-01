import React from 'react';
import PropTypes from 'prop-types';
import { Content } from 'App/View/Content';
import Notifications from 'App/View/Notifications/index';

const propTypes = {
    service: PropTypes.shape({
        getStoreItem: PropTypes.func.isRequired,
    }).isRequired,
};

const AuthorizedUserWrapper = ({ service, children }) => {
    return (
        <div className="main-wrap">
            <Content service={service}>{children}</Content>
            <Notifications />
        </div>
    );
};

AuthorizedUserWrapper.propTypes = propTypes;

export default AuthorizedUserWrapper;
