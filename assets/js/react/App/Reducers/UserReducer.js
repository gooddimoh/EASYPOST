import { schemaReducer } from 'Services';
import Constants from '../Constants/Modal/Payment';
import registrationConstants from '../Constants/Modal/Registration';

export const initState = {
    id: '',
    fullName: '',
    photo: '',
    company: '',
    balance: 0,
    permissions: [],
    activePackage: null,
    email: '',
    companyType: null,
    companyName: null,
    confirmed: false,
};

export const reducer = {
    [Constants.FETCH_BALANCE]: ({ data }) => data,
    [Constants.PACKAGE_LINK_PLAN]: ({ data }) => ({ activePackage: data }),
    [registrationConstants.REGISTRATION_CONFIRMED]: () => ({ confirmed: true }),
};

export default schemaReducer(initState, reducer);
