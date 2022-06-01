import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const ReceiveLabels = ({ className, handleSetActive }) => {
    const status = `'status': true,`;
    const pagination = `'pagination': {`;
    const count = `'count': 2,`;
    const total = `'total': 2,`;
    const per_page = `'per_page': 50,`;
    const page = `'page': 1,`;
    const pages = `'pages': 1`;
    const items = `'items': [`;
    const itemId1 = `'id': '7ed4e54b-3822-40df-9613-af58ed321dbb',`;
    const itemDate1 = `'date': '2021-09-27 09:04:05',`;
    const itemSender1 = `'sender': '4133 Veterans Memorial Drive 4133 Veterans Memorial Drive Batavia NY US 14020',`;
    const itemRecipient1 = `'recipient': '5399 W Genesse St 5399 W Genesse St Camillus NY US 13031',`;
    const itemStatus1 = `'status': 10,`;
    const itemWeight1 = `'weight': '5.00',`;
    const itemPrice1 = `'price': 3400,`;
    const itemPickupPrice1 = `'pickup_price': null,`;
    const itemPickupId1 = `'pickup_id': null,`;
    const itemService1 = `'service': 'Express',`;
    const itemCarrier1 = `'carrier': 'USPS',`;
    const itemTrack1 = `'track': '9470100895232079891769',`;
    const itemLabelUrl1 = `'label_url': 'https://easypost-files.s3.us-west-2.amazonaws.com/files/postage_label/20210927/9bbe824a89be4ae29aa8f11a95708590.pdf',`;
    const itemNeedPickup1 = `'need_pickup': '0'`;

    const itemId2 = `'id': 'cef55770-fc10-40e4-b581-155f7ee383ef',`;
    const itemDate2 = `'date': '2021-09-28 09:33:27',`;
    const itemSender2 = `'sender': '5399 W Genesse St 5399 W Genesse St Camillus NY US 13031',`;
    const itemRecipient2 = `'recipient': '3191 County rd 10 3191 County rd 10 Canandaigua NY US 14424',`;
    const itemStatus2 = `'status': 10,`;
    const itemWeight2 = `'weight': '7.00',`;
    const itemPrice2 = `'price': 5284,`;
    const itemPickupPrice2 = `'pickup_price': 250,`;
    const itemPickupId2 = `'pickup_id': 'pickuprate_45b6ecae64ed4c44952c9b7096f723c0',`;
    const itemService2 = `'service': 'PRIORITY_OVERNIGHT',`;
    const itemCarrier2 = `'carrier': 'FedEx',`;
    const itemTrack2 = `'track': '794668531785',`;
    const itemLabelUrl2 = `'label_url': 'https://easypost-files.s3.us-west-2.amazonaws.com/files/postage_label/20210928/d0ccf0606b094d65921731040c1a2d9f.pdf',`;
    const itemNeedPickup2 = `'need_pickup': '0'`;
    const columns = `'columns': [`;
    const columnsDate = `'date',`;
    const columnsSender = `'sender',`;
    const columnsRecipient = `'recipient',`;
    const columnsWeight = `'weight',`;
    const columnsService = `'service',`;
    const columnsCarrier = `'carrier',`;
    const columnsTrack = `'track',`;
    const columnsPrice = `'price',`;
    const columnsPickupPrice = `pickup_price`;

    const code401 = `'code': 401,`;
    const message401 = `'message': 'Invalid credentials.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Receive Labels</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>GET</span> https://erp.loc/api/labels</div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Request</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: application/json</div>
                        <div className="accordion__block-text">Content-Type: Bearer {'<token>'}</div>
                    </div>
                </div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Response 200</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: application/json</div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">BODY</div>
                        <div className="accordion__block-code">
                            <div className="accordion__block-text">
                                <div  className="accordion__block-text">{status}</div>
                                <div  className="accordion__block-text">{pagination}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{count}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{total}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{per_page}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{page}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{pages}</div>
                                <div  className="accordion__block-text">{'},'}</div>
                                <div  className="accordion__block-text">{items}</div>
                                <div  className="accordion__block-text">{'{'}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemId1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemDate1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemSender1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemRecipient1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemStatus1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemWeight1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemPrice1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemPickupPrice1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemPickupId1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemService1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemCarrier1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemTrack1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemLabelUrl1}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemNeedPickup1}</div>
                                <div  className="accordion__block-text">{'},'}</div>
                                <div  className="accordion__block-text">{'{'}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemId2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemDate2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemSender2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemRecipient2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemStatus2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemWeight2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemPrice2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemPickupPrice2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemPickupId2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemService2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemCarrier2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemTrack2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemLabelUrl2}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{itemNeedPickup2}</div>
                                <div  className="accordion__block-text">{'},'}</div>
                                <div  className="accordion__block-text">],</div>
                                <div  className="accordion__block-text">{columns}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsDate}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsSender}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsRecipient}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsWeight}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsService}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsCarrier}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsTrack}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsPrice}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{columnsPickupPrice}</div>
                                <div  className="accordion__block-text">]</div>
                                <div  className="accordion__block-text">{'}'}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Response 401</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: application/json</div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">BODY</div>
                        <div className="accordion__block-code">
                            <div className="accordion__block-text">{code401}</div>
                            <div className="accordion__block-text">{message401}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default compose(withTagDefaultProps, AccordionHoc)(ReceiveLabels);