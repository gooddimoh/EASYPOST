import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    apiIntegrationStore: Store,
});

ReactOnRails.register({ ApiIntegration: App("apiIntegrationStore") });
