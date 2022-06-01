import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    registrationStore: Store,
});

ReactOnRails.register({ Registration: App("registrationStore") });
