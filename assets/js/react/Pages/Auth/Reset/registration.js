import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    resetStore: Store,
});

ReactOnRails.register({ Reset: App('resetStore') });
