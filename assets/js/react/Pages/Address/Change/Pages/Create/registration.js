import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    addressCreateStore: Store,
});

ReactOnRails.register({ AddressCreate: App('addressCreateStore') });
