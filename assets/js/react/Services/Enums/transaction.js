import { t } from 'Services/i18n';

const transactionType = {
    debit: '1',
    credit: '2',
};

const transactionTypeOptions = [
    { value: transactionType.debit, label: t('Debit') },
    { value: transactionType.credit, label: t('Credit') },
];

const transactionStatus = {
    fail: '0',
    pending: '1',
    success: '2',
};

const transactionStatusOptions = [
    { value: transactionStatus.fail, label: t('Fail'), color: 'warn' },
    { value: transactionStatus.pending, label: t('Pending'), color: 'danger' },
    { value: transactionStatus.success, label: t('Success'), color: 'current' },
];

export {
    transactionType,
    transactionTypeOptions,
    transactionStatus,
    transactionStatusOptions
};