import React from 'react';
import PropTypes from 'prop-types';
import connect from 'Hoc/Template/Connect';
import { ServiceProvider } from 'Services/Context';
import AuthorizedUserWrapper from 'App/View/Content/AuthorizedUserWrapper';
import { ToastContainer } from 'react-toastify';

const propTypes = {
    userId: PropTypes.string.isRequired,
    service: PropTypes.objectOf(PropTypes.any).isRequired,
};

const AuthWrapper = ({ userId, service, children }) => {
    return (
        <>
            {userId ? (
                <AuthorizedUserWrapper service={service}>{children}</AuthorizedUserWrapper>
            ) : (
                <ServiceProvider value={service}>{children}</ServiceProvider>
            )}
            <ToastContainer autoClose={5000} draggable closeOnClick hideProgressBar limit={4} />
        </>
    );
};

AuthWrapper.propTypes = propTypes;

const mapStateToProps = (state) => ({
    userId: state.userState.id,
});

export default connect(mapStateToProps)(AuthWrapper);
