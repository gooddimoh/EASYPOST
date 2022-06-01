import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const ReceiveBalance = ({ className, handleSetActive }) => {
    const status = `'status': true,`;
    const message = `'message': {`;
    const balance = `'balance': 4360`;
    const code = `'code': 401,`;
    const message401 = `'message': 'Invalid credentials.'`;
    const status500 = `'status': false,`;
    const errors500 = `'errors': {`;
    const code500 = `'code': 1000,`;
    const title500 = `'title': 'Invalid request parameter.',`;
    const detail500 = `'detail': 'Company not found.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Receive Balance</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>GET</span> https://erp.loc/api/companies/balance</div>
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
                                <div  className="accordion__block-text">{message}</div>
                                <div  className="accordion__block-text accordion__block-text_pl-2">{balance}</div>
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
                            <div className="accordion__block-text">{code}</div>
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
                            <div className="accordion__block-text">{errors500}</div>
                            <div className="accordion__block-text  accordion__block-text_pl-2">{code500}</div>
                            <div className="accordion__block-text  accordion__block-text_pl-2">{title500}</div>
                            <div className="accordion__block-text  accordion__block-text_pl-2">{detail500}</div>
                            <div className="accordion__block-text">{'}'}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default compose(withTagDefaultProps, AccordionHoc)(ReceiveBalance);