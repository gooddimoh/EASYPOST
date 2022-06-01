import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    packageStore: Store,
});

ReactOnRails.register({ Package: App("packageStore") });
