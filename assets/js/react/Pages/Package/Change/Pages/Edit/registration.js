import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    packageEditStore: Store
});

ReactOnRails.register({PackageEdit: App('packageEditStore')});