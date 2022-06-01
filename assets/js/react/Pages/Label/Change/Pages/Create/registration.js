import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    labelCreateStore: Store,
});

ReactOnRails.register({ LabelCreate: App('labelCreateStore') });
