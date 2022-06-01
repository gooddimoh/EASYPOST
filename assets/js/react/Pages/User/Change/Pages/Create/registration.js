import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    userCreateStore: Store,
});

ReactOnRails.register({ UserCreate: App('userCreateStore') });
