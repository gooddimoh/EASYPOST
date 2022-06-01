import { t } from 'Services/i18n';

const companyType = {
    single_person: '2',
    company: '1',
};

const companyTypeOptions = ([
    { value: companyType.company, label: t('Company') },
    { value: companyType.single_person, label: t('Single person') },
]);

export {
    companyType,
    companyTypeOptions,
};