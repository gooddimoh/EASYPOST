import { t } from 'Services/i18n';

const addressBookType = {
    sender: '1',
    recipient: '2',
};

const addressBookTypeOptions = ([
    { value: addressBookType.sender, label: t('Sender') },
    { value: addressBookType.recipient, label: t('Recipient') },
]);

const addressTypeOptions = ([
    { value: '1', label: t('Company') },
    { value: '2', label: t('Personal') },
]);

export {
    addressBookType,
    addressBookTypeOptions,
    addressTypeOptions
};