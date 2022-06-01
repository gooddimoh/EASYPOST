import ReactOnRails from 'react-on-rails';
import React from 'react';
import Root from 'App/View/Root';
import Index from './Index';
import _service from './Services';

const App = storeName => () => {
    const store = ReactOnRails.getStore(storeName);
    const id = store.getState().pageState.token;

    const service = {
        ..._service,
        requestOnSubmitForm: _service.requestOnSubmitForm(id),
    };

    return (
        <Root store={store} service={service}>
            <Index />
        </Root>
    );
};

export default App;
