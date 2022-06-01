import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    userStore: Store,
});

ReactOnRails.register({ User: App('userStore') });
