import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoLabels = ({ t }) => {
    return (
        <div className="info-manual__text">
            {t(
                'Ship your item effortlessly around the world with a postal service of your choice. Now you have the option of shipping your package through USPS both domestically and internationally right out of your house or office. You can also choose FedEx Express or UPS shipping services, if your shipment is time-sensitive and requires a door-to-door delivery.Please click the “Add label” button and fill in the forms (sender/recipient) provided. Click the “Get rates now” to choose the most affordable rate, then create a shipping label, make sure everything is correct and print it out. It is advisable that you use either laser or thermal label printers. You can drop off your package at a post-office or schedule a pickup with us.All your shipments are trackable with us, so you will have a peace of mind knowing the exact location of your item at every phase of the shipping process.',
            )}
        </div>
    );
};

export default withTagDefaultProps(InfoLabels);
