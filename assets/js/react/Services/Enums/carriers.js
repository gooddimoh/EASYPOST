import { permissionsEnum } from './general';

const carriersType = {
    ups: 'UpsAccount',
    fedex: 'FedexAccount',
    usps: 'UspsAccount',
};

const carriersPermission = {
    [carriersType.ups]: permissionsEnum.ups,
    [carriersType.fedex]: permissionsEnum.fedex,
};

export { carriersType, carriersPermission };
