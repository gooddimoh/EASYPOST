import React from 'react';
import {compose} from 'ramda';
import {withTagDefaultProps} from 'Hoc/Template';
import {Img} from 'Templates/Img';
import AccordionHoc from './AccordionHOC';

const ReceiveToken = ({ className, handleSetActive }) => {
    const token = `token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzI0MDQwMjcsImV4cCI6MTY2Mzk0MDAyNywicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfQ0FSUklFUlMiLCJST0xFX1VTRV9VU1BTIiwiUk9MRV9DT01QQU5ZIl0sInVzZXJuYW1lIjoidGVzdEB0ZXN0LnRlc3QifQ.kh6AUntIIxSz4soBy0KaBWz6jzW9dmbDRBxWeDO7GmBNQrfVoY2kXyoCQGb7QdvTZ6sI8xXT57QdP78J6n6VQDc3Vz7msQoDw5d_YcaTGIH0kbSKlBjOIB6_qU6M-HOzPpZqLPHuCscscUMXgN_v5RVt5JCkCOAHQ_jnHGx3q4zY9hcrQfE2CFO5qJxZ5zrluD8zftnap7Vz-JuJvafzU4aenVe9juATEJQY5OTaUUIYXfJ053nE8wij7fkD8lASXKRryXON6zFmbZX25lr5THcTDfQR8xyQwNxspXiT5pEw8f3iKTBhGnZOvv5dgnETTOopqHiaALNMwaqQo6lprW33-69zM7VWWDpGo3ZIQZZyQxXvApuSTfeWgLKO_ljcz_a0Nrvn6-ew0-4dYXGwX67cxh-4ettQ08UfFAopeZJy_sA8BaacuUDRbQZ5SWgwmTSWgR2RmH-rOoGK1hzM-pSlXAoEBL9AVttEZFoFpYMjEzXLZIFpm7CrsV2hOuL7UeGdCBxhMd06lUz3VjVFkwv_NB1WCAyaZQq05hxkmjRSFsnkw-7FN5gvitemo7xLUGKqnlJ4NsrAx1pbIN7dOG9A4_UYRV-QrrKn8-SLLrJLt0Wakt5Uewgl0cIvdHNEpsIiNLXEOoE2FbDqmVmtiQeVyCUtNv8kUSKMy-iuwo0',`;
    const code = `'code': 401,`;
    const message = `'message': 'Invalid credentials.'`;

    return (
        <div className="api-integration__block accordion">
            <div className={`accordion__box ${className}`} onKeyDown={handleSetActive} onClick={handleSetActive}>
                <div className="accordion__title">Receive Token</div>
                <Img className="accordion__icon" img="arrow-dropdown" alt="arrow dropdown" />
            </div>
            <div className={`accordion__info ${className}`}>
                <div className="accordion__method"><span>POST</span> https://erp.loc/api/login</div>
                <div className="accordion__item">
                    <div className="accordion__suptitle">Request</div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">ATTRIBUTES</div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    email
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                        <div className="accordion__block-item">
                            <div className="accordion__block-box">
                                <div className="accordion__block-box__text">
                                    password
                                    <span>required</span>
                                </div>
                                <div className="accordion__block-box__text">string</div>
                            </div>
                        </div>
                    </div>
                    <div className="accordion__block">
                        <div className="accordion__block-title">HEADERS</div>
                        <div className="accordion__block-text">Content-Type: multipart/form-data</div>
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
                                {token}
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
                            <div className="accordion__block-text">{message}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default compose(withTagDefaultProps, AccordionHoc)(ReceiveToken);