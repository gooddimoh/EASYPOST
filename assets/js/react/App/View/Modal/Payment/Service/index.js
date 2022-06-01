import { compose } from 'ramda';
import { serviceProps } from 'Services';
import { requestOnSubmit } from './RequestService';
import { renderMethodFields, initialStates, succesfullyText, checkVerifyView } from './ViewService';
import { getStoreItem, getActionStore } from './StoreService';
import { validOnSubmit } from './ValidateService';
import { formData, formDataManualAnonymous, formDataManualVerification } from './FormService';

export default serviceProps('', 'funds-modal', {
    getStoreItem,
    getActionStore,
    renderMethodFields,
    initialStates,
    succesfullyText,
    checkVerifyView,
    createPaymentIntent: compose(requestOnSubmit('/funds/stripe/create-payment-intent'), formData),
    addPaymentStripe: requestOnSubmit('/funds/stripe/add'),
    addPaymentPaypal: requestOnSubmit('/funds/paypal/add'),
    createLinkToken: requestOnSubmit('/funds/bank-transfer/auto/create-link-token'),
    chargeAutoTransfer: compose(requestOnSubmit('/funds/bank-transfer/auto/charge'), formData),
    createNewCharge: requestOnSubmit('/funds/bank-transfer/auto/new-charge'),
    isCustomerLink: requestOnSubmit('/funds/bank-transfer/manual/is-customer-link', 'GET'),
    createCustomer: requestOnSubmit('/funds/bank-transfer/manual/create-customer'),
    verifyCustomer: requestOnSubmit('/funds/bank-transfer/manual/verify'),
    createManualCharge: compose(requestOnSubmit('/funds/bank-transfer/manual/charge'), formData),
    validOnSubmit,
    formDataManualAnonymous,
    formDataManualVerification,
});
