import { trackingServices } from 'Services/Enums';
import { schemaCall } from 'Services';

const getTrackingLink = schemaCall({
    [trackingServices.Usps] : (id) => `https://tools.usps.com/go/TrackConfirmAction?tLabels=${id}`,
    [trackingServices.FedEx] : (id) => `https://www.fedex.com/fedextrack/?trknbr=${id}`,
    [trackingServices.Ups] : (id) => `https://www.ups.com/track?tracknum=${id}`,
    _: () => '#',
});

export { getTrackingLink };