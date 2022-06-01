import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const ReceiveOneLabel = ({ className, handleSetActive }) => {
    const status = `'status': true,`;
    const message = `'message': {`;
    const id = `'id': 'cef55770-fc10-40e4-b581-155f7ee383ef',`;
    const date = `'date': '2021-09-28 09:33:27',`;
    const senderName = `'sender_name': 'Tolik Katolik',`;
    const senderType = `'sender_type': 1,`;
    const senderCode = `'sender_code': '+380',`;
    const senderPhone = `'sender_phone': '9312345',`;
    const senderEmail = `'sender_email': 'tolik@test.com',`;
    const senderStreet1 = `'sender_street1': '5399 W Genesse St',`;
    const senderStreet2 = `'sender_street1': '5399 W Genesse St',`;
    const senderCity = `'sender_city': 'Camillus',`;
    const senderState = `'sender_state': 'NY',`;
    const senderCounty = `'sender_country': 'US'`;
    const senderZip = `'sender_zip': '13031',`;
    const recipientName = `'recipient_name': 'Vasia Pupkin',`;
    const recipientType = `'recipient_type': 1,`;
    const recipientCode = `'recipient_code': '+380',`;
    const recipientPhone = `'recipient_phone': '9312345',`;
    const recipientEmail = `'recipient_email': 'vasia@test.com',`;
    const recipientStreet1 = `'recipient_street1': '3191 County rd 10',`;
    const recipientStreet2 = `'recipient_street2': '3191 County rd 10',`;
    const recipientCity = `'recipient_city': 'Canandaigua',`;
    const recipientState = `'recipient_state': 'NY',`;
    const recipientCountry = `'recipient_country': 'US',`;
    const recipientZip = `'recipient_zip': '14424',`;
    const weight = `'weight': '7.00',`;
    const price = `'price': 5284,`;
    const shipmentId = `'shipment_id': 'shp_52954e77b44748d0b9a4fe2265d12d1a',`;
    const pickupPrice = `'pickup_price': 250,`;
    const pickupId = `'pickup_id': 'pickuprate_45b6ecae64ed4c44952c9b7096f723c0',`;
    const service = `'service': 'PRIORITY_OVERNIGHT',`;
    const carrier = `'carrier': 'FedEx',`;
    const track = `'track': '794668531785',`;
    const labelUrl = `'label_url': 'https://easypost-files.s3.us-west-2.amazonaws.com/files/postage_label/20210928/d0ccf0606b094d65921731040c1a2d9f.pdf'`;

    const code401 = `'code': 401,`;
    const message401 = `'message': 'Invalid credentials.'`;

    const status500 = `'status': false,`;
    const message500 = `'message': {`;
    const code500 = `'code': 1000,`;
    const title500 = `'title': 'Invalid request parameter.',`;
    const detail500 = `'detail': 'Label not found.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Receive One Label</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>GET</span> https://erp.loc/api/labels/id</div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Parameters</div>
                    <div className="accordion__block">
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">id</div>
                                <div className="accordion__block-box__text">Label id Example: cef55770-fc10-40e4-b581-155f7ee383ef.</div>
                                <div className="accordion__block-box__text">String</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Request</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: application/json</div>
                        <div className="accordion__block-text">Content-Type: Bearer {'<token>'}</div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">BODY</div>
                        <div className="accordion__block-code">
                            <div className="accordion__block-text">
                                <div className="accordion__block-text">{status}</div>
                                <div className="accordion__block-text">{message}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{id}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{date}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderName}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderType}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderCode}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderPhone}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderEmail}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderStreet1}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderStreet2}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderCity}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderState}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderCounty}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{senderZip}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientName}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientType}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientCode}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientPhone}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientEmail}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientStreet1}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientStreet2}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientCity}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientState}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientCountry}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2">{recipientZip}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{weight}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{price}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{shipmentId}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{pickupPrice}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{pickupId}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{service}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{carrier}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{track}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{labelUrl}</div>
                                <div className="accordion__block-text accordion__block-text_pl-2 accordion__block-text_pl-2">{'}'}</div>
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
                <div className="accordion__item">
                    <div className="accordion__suptitle">Response 500</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: application/json</div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">BODY</div>
                        <div className="accordion__block-code">
                            <div className="accordion__block-text">{status500}</div>
                            <div className="accordion__block-text">{message500}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{code500}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{title500}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{detail500}</div>
                            <div className="accordion__block-text">{'}'}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default compose(withTagDefaultProps, AccordionHoc)(ReceiveOneLabel);