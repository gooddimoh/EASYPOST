import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    apiDocStore: Store
});

ReactOnRails.register({ApiDoc: App('apiDocStore')});