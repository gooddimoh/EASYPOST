import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    labelCloneStore: Store,
});

ReactOnRails.register({ LabelClone: App('labelCloneStore') });
