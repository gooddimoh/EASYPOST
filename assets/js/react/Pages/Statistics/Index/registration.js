import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    statisticsStore: Store,
});

ReactOnRails.register({ Statistics: App("statisticsStore") });
