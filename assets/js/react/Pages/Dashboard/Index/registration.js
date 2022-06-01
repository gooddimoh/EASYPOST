import ReactOnRails from "react-on-rails";
import App from "./App";
import Store from "./Store";

ReactOnRails.registerStore({
    dashboardStore: Store,
});

ReactOnRails.register({ Dashboard: App("dashboardStore") });
