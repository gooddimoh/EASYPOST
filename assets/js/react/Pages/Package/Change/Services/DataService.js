import {permissionsEnum} from 'Services/Enums';

export const normalizeCarriers = (data) =>
    data.reduce((acc, current) => {
        const value = `ROLE_CARRIERS_${current.name.toUpperCase()}`;
        if (value !== permissionsEnum.usps) {
            acc.push({
                label: current.name,
                value,
            });
        }
        return acc;
    }, []);

const normalizeUseCarriers = (arr) => arr.map((i) => i.replace(/CARRIERS/, 'USE'));

export const dataRequestNormalizer = (data) => {
    const newData = {
        id: data.id,
        name: data.name,
        price_label: data.price_label * 100,
        price_month: data.price_month * 100,
        price_additional: data.price_additional * 100,
        permissions: [
            ...data.api,
            ...data.pickup,
            ...data.carriers,
            ...normalizeUseCarriers(data.useCarriers),
            permissionsEnum.carriers
        ],
    };

    if (data.available_company) {
        newData.available_company = data.available_company;
    }

    return newData;
};

export const dataResponseNormalizer = (data) => {
    const newData = {
        id: data.id,
        name: data.name,
        available_company: data.available_company,
        price_label: (data.price_label / 100).toString(),
        price_month: (data.price_month / 100).toString(),
        price_additional: (data.price_additional / 100).toString(),
    };

    if (data.permissions.includes(permissionsEnum.api)) {
        newData.api = [permissionsEnum.api];
    }

    if (data.permissions.includes(permissionsEnum.pickup)) {
        newData.pickup = [permissionsEnum.pickup];
    }

    newData.carriers = data.permissions.filter((e) => e && [
        permissionsEnum.usps,
        permissionsEnum.ups,
        permissionsEnum.fedex
    ].includes(e));

    newData.useCarriers = data.permissions.reduce((acc, current) => {
        if ([permissionsEnum.useUsps, permissionsEnum.useUps, permissionsEnum.useFedex].includes(current)) {
            acc.push(current.replace(/USE/, 'CARRIERS'));
        }
        return acc;
    }, []);

    return newData;
};
