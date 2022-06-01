import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const BuyLabel = ({ className, handleSetActive }) => {
    const status = `'status': true,`;
    const message = `'message': {`;
    const id = `'id': '9f1bc311-3b8f-4198-93e0-9b007a130dbd'`;

    const code401 = `'code': 401`;
    const message401 = `'message': 'Invalid credentials.'`;

    const status501 = `'status': false,`;
    const errors501 = `'errors': {`;
    const code501 = `'code': 1000,`;
    const title501 = `'title': 'Invalid request parameter.',`;
    const detail501 = `'detail': 'Failed to buy shipment.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Buy Label</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>POST</span> https://erp.loc/api/labels/create</div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Request</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">ATTRIBUTES</div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    shipment_id
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    shipment_rate_id
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
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
                                    recipient_name
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_type
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
                                    recipient_code
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_phone
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_email
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_street1
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_street2
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_city
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_state
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_country
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    recipient_zip
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    type
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">enum</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    1
                                    <span>Domestic US</span>
                                </div>
                                <div className="accordion__block-box__text">number</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    2
                                    <span>World</span>
                                </div>
                                <div className="accordion__block-box__text">number</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    weight
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    length
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    width
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    height
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">options</div>
                                <div className="accordion__block-box__text">object</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">need_pickup</div>
                                <div className="accordion__block-box__text">enum</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-4">
                                <div className="accordion__block-box__text">
                                    0
                                    <span>No</span>
                                </div>
                                <div className="accordion__block-box__text">number</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-4">
                                <div className="accordion__block-box__text">
                                    10
                                    <span>Yes</span>
                                </div>
                                <div className="accordion__block-box__text">number</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    packages
                                    <span>Only for world label</span>
                                </div>
                                <div className="accordion__block-box__text">array</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-1">
                                <div className="accordion__block-box__text">object</div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    description
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">
                                    string <br/>
                                    Product description
                                </div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    quantity
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">
                                    number <br/>
                                    Item quantity
                                </div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    weight
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">
                                    string <br/>
                                    Item weight
                                </div>
                            </div>
                            <div className="accordion__block-box accordion__block-box_pl-2">
                                <div className="accordion__block-box__text">
                                    price
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">
                                    string <br/>
                                    Item price
                                </div>
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
                            <div className="accordion__block-text accordion__block-text_pl-2">{id}</div>
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
                <div className="accordion__item">
                    <div className="accordion__suptitle">Response 500</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: application/json</div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">BODY</div>
                        <div className="accordion__block-code">
                            <div className="accordion__block-text">{status501}</div>
                            <div className="accordion__block-text">{errors501}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{code501}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{title501}</div>
                            <div className="accordion__block-text accordion__block-text_pl-2">{detail501}</div>
                            <div className="accordion__block-text">{'}'}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default compose(withTagDefaultProps, AccordionHoc)(BuyLabel);