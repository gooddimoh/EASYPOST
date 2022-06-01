import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    newsStore: Store,
});

ReactOnRails.register({ News: App("newsStore") });
