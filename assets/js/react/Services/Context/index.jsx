import React from 'react';

const { Provider: ServiceProvider, Consumer: ServiceConsumer } = React.createContext();

const withServiceConsumer = (Wrapped) => (props) => (
    // eslint-disable-next-line react/jsx-props-no-spreading
    <ServiceConsumer>{(service) => <Wrapped {...props} service={service} />}</ServiceConsumer>
);

export { ServiceProvider, ServiceConsumer, withServiceConsumer };
