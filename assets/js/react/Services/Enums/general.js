import { t } from 'Services/i18n';

const rowsPerPageOptions = [
    { value: '10', label: 10 },
    { value: '20', label: 20 },
    { value: '50', label: 50 },
    { value: '100', label: 100 },
];

const permissionsEnum = {
    admin: 'ROLE_ADMIN',
    owner: 'ROLE_COMPANY_OWNER',
    manager: 'ROLE_COMPANY_MANAGER',
    carriers: 'ROLE_CARRIERS',
    usps: 'ROLE_CARRIERS_USPS',
    ups: 'ROLE_CARRIERS_UPS',
    fedex: 'ROLE_CARRIERS_FEDEX',
    useUsps: 'ROLE_USE_USPS',
    useUps: 'ROLE_USE_UPS',
    useFedex: 'ROLE_USE_FEDEX',
    pickup: 'ROLE_PICKUP',
    api: 'ROLE_API',
    company: 'ROLE_COMPANY',
    single_person: 'ROLE_SINGLE_PERSON',
};

const roleOptions = [
    { value: permissionsEnum.admin, label: t('Admin') },
    { value: permissionsEnum.owner, label: t('Company owner') },
    { value: permissionsEnum.manager, label: t('Company manager') },
];

const statusEnum = {
    active: '10',
    delete: '0',
};

const userStatus = {
    ...statusEnum,
    unconfirmed: '5',
};

const statusEnumOptions = [
    { value: statusEnum.active, label: t('Active') },
    { value: statusEnum.delete, label: t('Delete') },
];

const userStatusOptions = [...statusEnumOptions, { value: userStatus.unconfirmed, label: t('Unconfirmed') }];

const statusEnumColorOptions = [
    { value: statusEnum.active, label: t('Active'), color: 'current' },
    { value: statusEnum.delete, label: t('Delete'), color: 'warn' },
];

const userStatusColorOptions = [
    ...statusEnumColorOptions,
    { value: userStatus.unconfirmed, label: t('Unconfirmed'), color: 'danger' },
];

export {
    statusEnum,
    rowsPerPageOptions,
    permissionsEnum,
    roleOptions,
    statusEnumOptions,
    statusEnumColorOptions,
    userStatus,
    userStatusOptions,
    userStatusColorOptions,
};
