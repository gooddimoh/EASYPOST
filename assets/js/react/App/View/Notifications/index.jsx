import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import 'react-toastify/dist/ReactToastify.min.css';
import * as service from './Services';

const Notifications = () => {
    return (
        <ServiceProvider value={service}>
            <div style={{ position: 'fixed', opacity: 0, margin: '-1px' }} />
        </ServiceProvider>
    );
};

export default withTagDefaultProps(Notifications);
