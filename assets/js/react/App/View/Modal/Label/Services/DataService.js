import { modalViewsEnum } from 'Services/Enums';

export const labelResponseNormalizer = (data) => {
    return {
        sender: {
            name: data.sender_name,
            type_address: data.sender_type,
            code: data.sender_code,
            phone: data.sender_phone,
            email: data.sender_email,
            street1: data.sender_street1,
            street2: data.sender_street2,
            city: data.sender_city,
            state: data.sender_state,
            country: data.sender_country,
            zip: data.sender_zip,
            status: data.status,
        },
        packages: data.packages,
        type: data.type,
        labelId: data.id,
        shipmentId: data.shipment_id,
        currentScreen: modalViewsEnum.pickupForm,
    };
};
