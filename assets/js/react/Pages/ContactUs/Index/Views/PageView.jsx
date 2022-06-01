import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { TopTitleWrap } from 'Templates/Title';
import { Form } from 'Templates/Form';
import { FormBlock } from './Form/index';

const PageView = ({ t }) => {
    return (
        <>
            <TopTitleWrap title="Contact Us" />
            <div className="contacts">
                <div className="contacts__desc">
                    <div className="contacts__text">
                        <p>{t('We would love to show you how to save time and money with "Postal Bridge"')}</p>
                        <p className="contacts__text-item">{t('Looking for Customer Support?')}</p>
                        <p>{t('Don’t worry, we’ve got you covered 24/7.')}</p>
                        <p>
                            {t(
                                'Contact our support team, and we will give handy guides and videos, individual consultation, and more.',
                            )}
                        </p>
                        <p>{t('Or try another way - Complete the form and we will get in touch with you shortly.')}</p>
                        <p className="contacts__text-item">{t('Want Us to Add a New Feature?')}</p>
                        <p>
                            {t(
                                'Product Feedback & Fresh Ideas form – We wish we could do everything for everyone, but at one day we can work only 24h. Have an idea? Nice ! Complete the product feedback form, and send this idea to our client manager - they will back to you, and give you an opportunity, to implement your idea to our service list.',
                            )}
                        </p>
                        <p className="contacts__text-item">{t('Want Us to Add a New Feature?')}</p>
                        <p>{t('Our office :')}</p>
                        <address>{t('651 N BROAD ST STE 205 4086')}</address>
                        <address>{t('MIDDLETOWN,')}</address>
                        <address>{t('DE 19709')}</address>
                        <p className="contacts__text-item">{t('contact phone : ')}<a href="tel:8009102990" className="contacts__text-link">(800) 910-2990</a></p>
                        <p className="contacts__text-item">{t('contact mail : ')}<a href="mailto:talk@postalbridge.com" className="contacts__text-link">talk@postalbridge.com</a></p>
                    </div>
                </div>
                <div className="contacts__form">
                    <Form>
                        <FormBlock />
                    </Form>
                </div>
            </div>
        </>
    );
};

export default withTagDefaultProps(PageView);
