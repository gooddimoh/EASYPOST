import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    newsCreateStore: Store,
});

ReactOnRails.register({ NewsCreate: App('newsCreateStore') });
