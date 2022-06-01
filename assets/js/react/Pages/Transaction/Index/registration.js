import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    transactionStore: Store,
});

ReactOnRails.register({ Transaction: App("transactionStore") });
