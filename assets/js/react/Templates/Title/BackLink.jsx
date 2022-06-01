import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import {Img} from '../Img';

const propTypes = {
    url: PropTypes.string.isRequired,
    t: PropTypes.func.isRequired,
    text: PropTypes.string
};

const defaultProps = {
    text: ''
};

const BackLink = ( { url, text, t } ) => {
    return (
        <a href={url} className="main-title__link">
            <Img img="arrow-left" alt={t('Back')}/>
            {text && <span className="main-title__text">{t(text)}</span>}
        </a>
    );
};

BackLink.propTypes = propTypes;
BackLink.defaultProps = defaultProps;


export default withTagDefaultProps(BackLink);