import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    carrierStore: Store,
});

ReactOnRails.register({ Carrier: App("carrierStore") });
