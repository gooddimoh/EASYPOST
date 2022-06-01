import React from 'react';
import { Provider } from 'react-redux';
import PropTypes from 'prop-types';
import { ErrorBoundary } from 'Error';
import { Preloader } from 'Templates/Preloader';
import AuthWrapper from 'App/View/AuthWrapper';
import { ModalContainer } from 'Widgets/Modal/ModalContainer';

const propTypes = {
    store: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.objectOf(PropTypes.any).isRequired,
};

const Root = ({ store, service, children }) => (
    <Provider store={store}>
        <ErrorBoundary>
            <AuthWrapper service={service}>{children}</AuthWrapper>
            <Preloader />
            <ModalContainer />
        </ErrorBoundary>
    </Provider>
);

Root.propTypes = propTypes;

export default Root;
