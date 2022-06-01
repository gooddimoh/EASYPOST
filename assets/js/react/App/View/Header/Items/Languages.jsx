import React, { useState } from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';
import { CustomOverlay } from 'Templates/CustomOverlay';
import { i18n } from 'Services/i18n';

const propTypes = {};
const defaultProps = {};

const Language = () => {
    const [showLang, setShowLang] = useState(false);
    const handleSetShowLang = () => {
        setShowLang(!showLang);
    };
    const _onClick = (e, str) => {
        e.preventDefault();
        i18n.change(str);
        window.location.reload();
    };
    const currentLanguage = i18n.language();
    const checkIcon = (() => {
        switch (currentLanguage) {
            case 'ru':
                return 'lang-ru';
            default:
                return 'lang-en';
        }
    })();

    return (
        <div className="lang">
            <button
                type="button"
                onClick={handleSetShowLang}
                className={`button button_header ${showLang ? 'active' : ''}`}
            >
                <Img className="lang__img" img={checkIcon} alt="current-lang" />
            </button>
            {showLang && (
                <ul className="lang__list">
                    <li className="lang__item">
                        <a href="#" className="lang__link" onClick={(e) => _onClick(e, 'en')}>
                            <span className="lang__text">en</span>
                            <Img className="lang__img" img="lang-en" alt="lang-icon" />
                        </a>
                    </li>
                    <li className="lang__item">
                        <a href="#" className="lang__link" onClick={(e) => _onClick(e, 'ru')}>
                            <span className="lang__text">ru</span>
                            <Img className="lang__img" img="lang-ru" alt="lang-icon" />
                        </a>
                    </li>
                </ul>
            )}
            <CustomOverlay onClick={handleSetShowLang} show={!showLang} />
        </div>
    );
};

Language.propTypes = propTypes;
Language.defaultProps = defaultProps;

export default withTagDefaultProps(Language);
