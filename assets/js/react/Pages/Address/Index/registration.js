import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    addressStore: Store,
});

ReactOnRails.register({ Address: App('addressStore') });
