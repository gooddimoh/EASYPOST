import { t } from 'Services/i18n';

const labelType = {
    world: '2',
    local: '1',
};

const labelTypeOptions = ([
    { value: labelType.world, label: t('Get international label. USPS US to World.') },
    { value: labelType.local, label: t('Get US domestic label. All Carriers.') },
]);

const trackingServices = {
    Usps: 'USPS',
    FedEx: 'FedEx',
    Ups: 'UPS',
};

export {
    labelType,
    labelTypeOptions,
    trackingServices,
};