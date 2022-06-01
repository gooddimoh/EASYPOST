import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    labelStore: Store,
});

ReactOnRails.register({ Label: App("labelStore") });
