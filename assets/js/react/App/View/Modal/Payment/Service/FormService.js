import { pathOr, multiply } from 'ramda';

export const formData = (data) => ({
    amount: multiply(pathOr('', ['amount'], data), 100),
});

export const formDataManualAnonymous = (data) => ({
    country: 'US',
    currency: 'usd',
    account_holder_type: 'individual',
    routing_number: data.routingNumber,
    account_number: data.accountNumber,
    account_holder_name: data.holderName,
});

export const formDataManualVerification = (data) => ({
    amount_first: data.amountFirst,
    amount_second: data.amountSecond,
});
