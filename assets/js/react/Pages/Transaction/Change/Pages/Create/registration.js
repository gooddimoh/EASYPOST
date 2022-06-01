import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    transactionCreateStore: Store,
});

ReactOnRails.register({ TransactionCreate: App('transactionCreateStore') });
