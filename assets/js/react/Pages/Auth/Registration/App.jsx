import ReactOnRails from "react-on-rails";
import React from "react";
import Root from "App/View/Root";
import Registration from "./Index";
import service from "./Services";

const App = (storeName) => () => {
    const store = ReactOnRails.getStore(storeName);

    return (
        <Root store={store} service={service}>
            <Registration />
        </Root>
    );
};

export default App;
