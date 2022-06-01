import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    waitStore: Store,
});

ReactOnRails.register({ Wait: App('waitStore') });
