import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const CreatePickup = ({ className, handleSetActive }) => {
    const status = `'status': true,`;
    const message = `'message': {`;
    const pickupId = `'pickup_id': 'pickup_304df05f3abd4e278b1d46a68a7f59c7',`;
    const columns = `'columns': [`;
    const serviceType = `'service_type',`;
    const amount = `'amount',`;
    const items = `'items': [`;
    const itemId1 = `'id': 'pickuprate_798422430e5d46a7b3377833132ed1ef',`;
    const itemServiceType1 = `'service_type': 'FedEx Future-day Express Pickup',`;
    const itemAmount1 = `'amount': 400`;
    const itemId2 = `'id': 'pickuprate_45b6ecae64ed4c44952c9b7096f723c0',`;
    const itemServiceType2 = `'service_type': 'FedEx Same-day Express Pickup',`;
    const itemAmount2 = `'amount': 250`;

    const code401 = `'code': 401`;
    const message401 = `'message': 'Invalid credentials.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Create Pickup</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>POST</span> https://erp.loc/api/labels/id/get-pickup-rates</div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Parameters</div>
                    <div className="accordion__block">
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">id</div>
                                <div className="accordion__block-box__text">Label id Example: 9f1bc311-3b8f-4198-93e0-9b007a130dbd</div>
                                <div className="accordion__block-box__text">String</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Request</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">ATTRIBUTES</div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_name
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_type
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">enum</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    1
                                    <span>Company</span>
                                </div>
                                <div className="accordion__block-box__text">number</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    2
                                    <span>Single person</span>
                                </div>
                                <div className="accordion__block-box__text">number</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_code
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_phone
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_email
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_street1
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_street2
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_city
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_state
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_country
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    sender_zip
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    min_date
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">
                                    string <br/>
                                    2021-09-30 12:13:00
                                </div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    max_date
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">
                                    string <br/>
                                    2021-09-30 14:07:00
                                </div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    instructions
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: multipart/form-data</div>
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
                            <div className="accordion__block-text">{status}</div>
                            <div className="accordion__block-text">{message}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{pickupId}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{columns}</div>
                            <div className="accordion__block-text accordion__block-text_pl-4">{serviceType}</div>
                            <div className="accordion__block-text accordion__block-text_pl-4">{amount}</div>
                            <div className="accordion__block-text">],</div>
                            <div className="accordion__block-text">{items}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{'{'}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{itemId1}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{itemServiceType1}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{itemAmount1}</div>
                            <div className="accordion__block-text">{'},'}</div>
                            <div className="accordion__block-text">{'{'}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{itemId2}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{itemServiceType2}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{itemAmount2}</div>
                            <div className="accordion__block-text">{'}'}</div>
                            <div className="accordion__block-text">]</div>
                            <div className="accordion__block-text">{'}'}</div>
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

export default compose(withTagDefaultProps, AccordionHoc)(CreatePickup);