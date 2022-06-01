import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    companyStore: Store,
});

ReactOnRails.register({ Company: App("companyStore") });
