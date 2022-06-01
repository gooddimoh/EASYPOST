import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    companyEditStore: Store,
});

ReactOnRails.register({ CompanyEdit: App('companyEditStore') });
