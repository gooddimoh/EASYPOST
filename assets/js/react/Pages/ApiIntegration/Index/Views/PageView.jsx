import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { TopTitleWrap } from 'Templates/Title';
import {
    ReceiveToken,
    ReceiveBalance,
    ReceiveLabels,
    ReceiveOneLabel,
    BuyPickup,
    CreateShipment,
    BuyLabel,
    CreatePickup,
} from './Accordion';

const PageView = () => {
    return (
        <>
            <TopTitleWrap title="API Integration" />
            <div className="api-integration">
                <div className="api-integration__item">
                    <div className="api-integration__block">
                        <div className="api-integration__title">Authorization</div>
                        <div className="api-integration__suptitle">To receive a token, send a request with your email and password.</div>
                    </div>
                    <ReceiveToken />
                </div>
                <div className="api-integration__item">
                    <div className="api-integration__block">
                        <div className="api-integration__title">Balance</div>
                    </div>
                    <ReceiveBalance />
                </div>
                <div className="api-integration__item">
                    <div className="api-integration__block">
                        <div className="api-integration__title">Labels</div>
                    </div>
                    <ReceiveLabels />
                    <ReceiveOneLabel />
                    <CreateShipment />
                    <BuyLabel />
                    <CreatePickup />
                    <BuyPickup />
                </div>
            </div>
        </>
    );
};

export default withTagDefaultProps(PageView);
