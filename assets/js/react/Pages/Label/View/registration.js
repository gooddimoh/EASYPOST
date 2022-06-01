import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    labelViewStore: Store,
});

ReactOnRails.register({ LabelView: App('labelViewStore') });
