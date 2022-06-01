import ReactOnRails from 'react-on-rails';
import App from './App';
import Store from './Store';

ReactOnRails.registerStore({
    companyViewStore: Store,
});

ReactOnRails.register({ CompanyView: App('companyViewStore') });
