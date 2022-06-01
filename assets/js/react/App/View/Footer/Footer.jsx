import React from 'react';
import { Img } from 'Templates/Img';

const Footer = () => {
    return (
        <footer className="footer">
                <div className="footer__wrap">
                        <div className="footer__info">
                                <div className="footer__block">
                                        <a href="tel:8009102990" className="footer__phone">(800) 910-2990</a>
                                        <a href="mailto:talk@postalbridge.com" className="footer__email">talk@postalbridge.com</a>
                                </div>
                                <ul className="social social_mobile">
                                        <li className="social__item">
                                                <a href="https://www.instagram.com/postalbridgeservice/" target="_blanc" className="social__link">
                                                        <Img img="instagram-social" alt="Instagram" className="social__img"/>
                                                </a>
                                        </li>
                                </ul>
                        </div>
                        <div className="footer__content">
                                <ul className="footer__menu">
                                        <li className="footer__item">
                                                <a href="https://new.postalbridge.com/privacy" className="footer__link">Privacy Policy</a>
                                        </li>
                                        <li className="footer__item">
                                                <a href="https://new.postalbridge.com/privacy" className="footer__link">Terms & Conditions</a>
                                        </li>
                                </ul>
                                <div className="copyright">© All rights reserved</div>
                        </div>
                        <ul className="social">
                                <li className="social__item">
                                        <a href="https://www.instagram.com/postalbridgeservice/" target="_blanc" className="social__link">
                                                <Img img="instagram-social" alt="Instagram" className="social__img"/>
                                        </a>
                                </li>
                        </ul>
                </div>
        </footer>
    );
};

export default Footer;