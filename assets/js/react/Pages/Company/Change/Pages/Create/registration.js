import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    companyCreateStore: Store,
});

ReactOnRails.register({ CompanyCreate: App('companyCreateStore') });
