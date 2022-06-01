import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    contactUsStore: Store,
});

ReactOnRails.register({ ContactUs: App("contactUsStore") });
