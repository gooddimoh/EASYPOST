import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const BuyPickup = ({ className, handleSetActive }) => {
    const status = `'status': true,`;
    const message = `'message': {`;
    const id = `'id': '9f1bc311-3b8f-4198-93e0-9b007a130dbd'`;
    const code401 = `'code': 401,`;
    const message401 = `'message': 'Invalid credentials.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Buy Pickup</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>POST</span> https://erp.loc/api/labels/id/buy-pickup</div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Parameters</div>
                    <div className="accordion__block">
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">id</div>
                                <div className="accordion__block-box__text">Label id Example: 9f1bc311-3b8f-4198-93e0-9b007a130dbd.</div>
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
                                    pickup_id
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    pickup_rate_id
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
            </div>
        </div>
    );
};

export default compose(withTagDefaultProps, AccordionHoc)(BuyPickup);