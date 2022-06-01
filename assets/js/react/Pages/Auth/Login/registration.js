import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    loginStore: Store,
});

ReactOnRails.register({ Login: App("loginStore") });
