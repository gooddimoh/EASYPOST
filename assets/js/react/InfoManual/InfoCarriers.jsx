import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoCarriers = ({ t }) => {
    return (
        <div className="info-manual__content">
            <div className="info-manual__block">
                <div className="info-manual__text">
                    {t(
                        'Select your shipping carrier for instant label creation. You can use our accounts with USPS, FedEx & UPS to take advantage of all the great features and benefits or you can use your own personal or business account.',
                    )}
                </div>
            </div>
            <div className="info-manual__block">
                <div className="info-manual__item">
                    <div className="info-manual__suptitle">FEDEX</div>
                    <ul className="info-manual__list">
                        <li className="info-manual__info">On-time express delivery worldwide</li>
                        <li className="info-manual__info">Long-haul delivery</li>
                        <li className="info-manual__info">Easy to use shipment paperwork</li>
                        <li className="info-manual__info">Free packaging</li>
                        <li className="info-manual__info">Sophisticated real-time tracking info</li>
                        <li className="info-manual__info">White glove services</li>
                    </ul>
                </div>
                <div className="info-manual__item">
                    <div className="info-manual__suptitle">UPS</div>
                    <ul className="info-manual__list">
                        <li className="info-manual__info">Worldwide package delivery</li>
                        <li className="info-manual__info">E-commerce shipping provider</li>
                        <li className="info-manual__info">Freight & ground shipping services</li>
                        <li className="info-manual__info">Same-day delivery express</li>
                        <li className="info-manual__info">Global presence</li>
                        <li className="info-manual__info">High brand equity</li>
                    </ul>
                </div>
                <div className="info-manual__item">
                    <div className="info-manual__suptitle">USPS</div>
                    <ul className="info-manual__list">
                        <li className="info-manual__info">Competitive flat rate</li>
                        <li className="info-manual__info">Guaranteed overnight delivery</li>
                        <li className="info-manual__info">24/7 shipping service</li>
                        <li className="info-manual__info">Insurance coverage of up to $5,000</li>
                        <li className="info-manual__info">Free package pickup</li>
                        <li className="info-manual__info">Delivers to mailboxes and P.O. boxes</li>
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default withTagDefaultProps(InfoCarriers);
