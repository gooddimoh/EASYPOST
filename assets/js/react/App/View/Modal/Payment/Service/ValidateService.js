import { propIs } from 'ramda';
import { required, numbers, validForm } from 'Services/Validation';
import { paymentType } from 'Services/Enums';

const commonFields = {
    method: [required],
    amount: [required],
};

const validManualAnonymous = {
    routingNumber: [required, numbers],
    accountNumber: [required, numbers],
    holderName: [required],
};

const validManualVerification = {
    amountFirst: [required, numbers],
    amountSecond: [required, numbers],
};

const validManual = (data) => {
    if (propIs(String, 'accountNumber', data)) return validManualAnonymous;
    return validManualVerification;
};

const validOnSubmit = (data) => {
    const { method: type } = data;
    const options = {
        [paymentType.card]: {
            ...commonFields,
            agree: [
                (val) =>
                    required(
                        val,
                        'You must agree to the Terms and Conditions, Privacy and Refund Policies to proceed.',
                    ),
            ],
        },
        [paymentType.autoTransfer]: commonFields,
        [paymentType.manualTransfer]: validManual(data),
        [paymentType.paypal]: commonFields,
        [paymentType.bitcoin]: commonFields,
    };

    return validForm(options[type])(data);
};

export { validOnSubmit };
