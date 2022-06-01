import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    newsEditStore: Store,
});

ReactOnRails.register({ NewsEdit: App('newsEditStore') });
