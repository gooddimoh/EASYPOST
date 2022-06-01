import ReactOnRails from 'react-on-rails';
import React from 'react';
import Root from 'App/View/Root';
import service from './Services';
import Index from './Index';

const App = (storeName) => () => {
    const store = ReactOnRails.getStore(storeName);

    return (
        <Root store={ store } service={ service }>
            <Index/>
        </Root>
    );
};

export default App;
