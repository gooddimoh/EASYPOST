import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    userChangePasswordStore: Store
});

ReactOnRails.register({UserChangePassword: App('userChangePasswordStore')});