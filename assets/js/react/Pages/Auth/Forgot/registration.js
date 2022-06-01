import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    forgotStore: Store,
});

ReactOnRails.register({Forgot: App('forgotStore')});
