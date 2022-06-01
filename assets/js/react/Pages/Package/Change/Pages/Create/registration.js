import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    packageCreateStore: Store,
});

ReactOnRails.register({ PackageCreate: App('packageCreateStore') });
