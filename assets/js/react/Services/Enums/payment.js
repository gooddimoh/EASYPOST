const paymentType = {
    card: '1',
    autoTransfer: '2',
    manualTransfer: '3',
    paypal: '4',
    bitcoin: '5',
    admin: '6',
};

const paymentMethods = [
    { value: paymentType.card, label: 'Debit/Credit Card via Stripe' },
    { value: paymentType.autoTransfer, label: 'Bank Transfer (ACH) Auto' },
    { value: paymentType.manualTransfer, label: 'Bank Transfer (ACH) Manual verification' },
    { value: paymentType.paypal, label: 'PayPal Instant' },
    // { value: paymentType.bitcoin, label: 'Bitcoin' },
    { value: paymentType.admin, label: 'Admin' },
];

const balanceAmount = [
    { value: '20', label: '$ 20' },
    { value: '50', label: '$ 50' },
    { value: '100', label: '$ 100' },
    { value: '150', label: '$ 150' },
    { value: '200', label: '$ 200' },
    { value: '250', label: '$ 250' },
    { value: '300', label: '$ 300' },
    { value: '350', label: '$ 350' },
    { value: '400', label: '$ 400' },
    { value: '450', label: '$ 450' },
    { value: '500', label: '$ 500' },
    { value: '550', label: '$ 550' },
    { value: '600', label: '$ 600' },
    { value: '700', label: '$ 700' },
    { value: '800', label: '$ 800' },
    { value: '1000', label: '$ 1000' },
];

const accountVerifyType = {
    notExist: '1',
    notVerify: '2',
    verify: '3',
};

export { paymentType, paymentMethods, balanceAmount, accountVerifyType };
