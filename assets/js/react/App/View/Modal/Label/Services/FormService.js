import { pathOr, multiply, includes } from 'ramda';
import { labelType } from 'Services/Enums';

const combineCommonData = (form) => ({
    sender_name: pathOr('', ['sender', 'name'], form),
    sender_type: pathOr('', ['sender', 'type'], form),
    sender_code: pathOr('', ['sender', 'code'], form),
    sender_phone: pathOr('', ['sender', 'phone'], form),
    sender_email: pathOr('', ['sender', 'email'], form),
    sender_street1: pathOr('', ['sender', 'street1'], form),
    sender_street2: pathOr('', ['sender', 'street2'], form),
    sender_city: pathOr('', ['sender', 'city'], form),
    sender_state: pathOr('', ['sender', 'state'], form),
    sender_country: pathOr('', ['sender', 'country'], form),
    sender_zip: pathOr('', ['sender', 'zip'], form),
    recipient_name: pathOr('', ['recipient', 'name'], form),
    recipient_type: pathOr('', ['recipient', 'type'], form),
    recipient_code: pathOr('', ['recipient', 'code'], form),
    recipient_phone: pathOr('', ['recipient', 'phone'], form),
    recipient_email: pathOr('', ['recipient', 'email'], form),
    recipient_street1: pathOr('', ['recipient', 'street1'], form),
    recipient_street2: pathOr('', ['recipient', 'street2'], form),
    recipient_city: pathOr('', ['recipient', 'city'], form),
    recipient_state: pathOr('', ['recipient', 'state'], form),
    recipient_country: pathOr('', ['recipient', 'country'], form),
    recipient_zip: pathOr('', ['recipient', 'zip'], form),
    type: pathOr('', ['type'], form),
    weight: pathOr('', ['weight'], form),
    length: pathOr('', ['parcel', 'length'], form),
    width: pathOr('', ['parcel', 'width'], form),
    height: pathOr('', ['parcel', 'height'], form),
    options: {
        need_pickup: includes('pickup', pathOr([], ['pickup'], form)) ? 10 : 0,
    },
});

const combineIdForSave = (form) => ({
    shipment_id: pathOr('', ['shipmentId'], form),
    shipment_rate_id: pathOr('', ['rateId'], form),
});

const combinePackagesData = (form) => ({
    packages: pathOr([], ['packages'], form).map(({ description, quantity, weight, price }) => ({
        description,
        quantity,
        weight,
        price: multiply(price, 100),
    })),
});

const labelTypes = (type, world, local) => {
    return {
        [labelType.world]: world,
        [labelType.local]: local,
    }[type];
};

export const formDataLabelRates = (data) => {
    return labelTypes(
        data.type,
        (a) => ({ ...combineCommonData(a), ...combinePackagesData(a) }),
        (a) => combineCommonData(a),
    )(data);
};

export const formDataPickupRates = (form) => ({
    sender_name: pathOr('', ['name'], form),
    sender_type: pathOr('', ['type'], form),
    sender_code: pathOr('', ['code'], form),
    sender_phone: pathOr('', ['phone'], form),
    sender_email: pathOr('', ['email'], form),
    sender_street1: pathOr('', ['street1'], form),
    sender_street2: pathOr('', ['street2'], form),
    sender_city: pathOr('', ['city'], form),
    sender_state: pathOr('', ['state'], form),
    sender_country: pathOr('', ['country'], form),
    sender_zip: pathOr('', ['zip'], form),
    minDate: pathOr('', ['minDate'], form),
    maxDate: pathOr('', ['maxDate'], form),
    instructions: pathOr('', ['instructions'], form),
});

export const formDataSave = (data) => {
    return labelTypes(
        data.type,
        (a) => ({ ...combineCommonData(a), ...combinePackagesData(a), ...combineIdForSave(a) }),
        (a) => ({ ...combineCommonData(a), ...combineIdForSave(a) }),
    )(data);
};
