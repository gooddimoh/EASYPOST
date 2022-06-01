import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import { close } from 'Widgets/Modal';
import MainBlock from './Views/MainBlock';
import service from './Service';

const propTypes = {
    kModal: PropTypes.string.isRequired,
    onSuccess: PropTypes.func,
};

const defaultProps = {
    onSuccess: () => {},
};

const Registration = ({ kModal, onSuccess }) => {
    return (
        <ServiceProvider value={service}>
            <MainBlock onClose={() => close(kModal)} onSuccess={onSuccess} />
        </ServiceProvider>
    );
};

Registration.propTypes = propTypes;
Registration.defaultProps = defaultProps;

export default withTagDefaultProps(Registration);
