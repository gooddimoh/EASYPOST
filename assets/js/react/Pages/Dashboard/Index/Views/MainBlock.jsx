import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import connect from 'Hoc/Template/Connect';
import { showRegistrationModal } from 'Widgets/Modal';
import { withTagDefaultProps } from 'Hoc/Template';
import { PageTitle } from 'Templates/Title';
import { DefaultButton } from 'Templates/Button';
import { Img } from 'Templates/Img';
import News from './News';

const propTypes = {
    confirmed: PropTypes.bool.isRequired,
    news: PropTypes.arrayOf(PropTypes.any).isRequired,
    pref: PropTypes.string.isRequired
};

const MainBlock = ({ confirmed, news, pref, t }) => {
    return (
        <>
            <div className={`about about_${pref}`}>
                <PageTitle title="About Us" />
                <div className={`about__row about__row_${pref}`}>
                    <div className={`about__col about__col_${pref}`}>
                        <div className={`about__text about__text_${pref}`}>
                            <p>
                                {t(`Postal Bridge is all about shipping labels. We offer our clients is a universal shipping label software that operates as a single well-set mechanism. Postal Bridge shipping label software will save you not only your time, but also your money.
                                `)}
                            </p>
                            <p>
                                {t(`Waiting in line at your local post office just to send a letter or two is definitely not an option. You only will lose money, time and desire to move forward. You have to get your priorities straight. The question is how to get the balance right? Postal Bridge shipping labels is the right way out.
                                `)}
                            </p>
                            <p>
                                {t(
                                    `Our shipping label printing software has proven its marketability and was eagerly co-opted by the global mainstream. Our productive business collaboration with such renowned multinational shipping services as FedEx & UPS along with the long-term cooperation with the United States Postal Service (USPS) will provide you with pragmatic and the most cost-effective solutions.`,
                                )}
                            </p>
                            <p>
                                {t(
                                    `Our low rates and flexible payment arrangements are appreciated by our customers and partners alike. We work hard to make your life a little easier. Postal Bridge is a shipping label service that pays back.`,
                                )}
                            </p>
                        </div>
                    </div>
                    <div className={`about__col about__col_${pref}`}>
                        <Img img="dashboard_image" alt="about_image" className={`about__img about__img_${pref}`} />
                    </div>
                </div>
                {!!news.length && (
                    <>
                        <h2 className={`about__title about__title_${pref}`}>{t('News')}</h2>
                        <div className={`about__row about__row_${pref}`}>
                            <News data={news} />
                        </div>
                    </>
                )}
                {!confirmed && (
                    <div className={`about__row about__row--single about__row_${pref} about__row--single_${pref}`}>
                        <div className={`about__col about__col_${pref}`}>
                            <div className={`about__desc about__desc_${pref}`}>
                                <p>
                                    {t(`In order to get full functionality, please  proceed with registration and select a service package. 
                                        Label creation trial is the only available option without complete registration`)}
                                </p>
                            </div>
                            <DefaultButton
                                key="registration"
                                onClick={() => showRegistrationModal()}
                                name="registration"
                            >
                                {t('Registration')}
                            </DefaultButton>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    confirmed: state.userState.confirmed,
    news: getStoreItem(state, 'newsItems', []),
});

export default compose(withTagDefaultProps, connect(mapStateToProps))(MainBlock);
