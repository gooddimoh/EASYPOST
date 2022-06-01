import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    labelEditStore: Store,
});

ReactOnRails.register({ LabelEdit: App('labelEditStore') });
