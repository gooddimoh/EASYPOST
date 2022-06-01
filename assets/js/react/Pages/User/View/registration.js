import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    userViewStore: Store,
});

ReactOnRails.register({ UserView: App('userViewStore') });
