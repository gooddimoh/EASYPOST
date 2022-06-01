import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    userEditStore: Store
});

ReactOnRails.register({UserEdit: App('userEditStore')});