import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import Img from '../Img/Img';

const propTypes = {
    src: PropTypes.string.isRequired,
    img: PropTypes.string,
    pref: PropTypes.string.isRequired,
    title: PropTypes.string,
    t: PropTypes.func.isRequired,
    blank: PropTypes.bool,
};

const defaultProps = {
    blank: false,
    img: '',
    title: '',
};

const ImageLink = ({ src, img, title, pref, t, blank }) => {
    return (
        <a
            href={src}
            target={blank ? '_blank' : '_self'}
            rel="noreferrer"
            className={`button button_simple button_${pref}`}
        >
            {img && <Img img={img} alt={t('link-icon')} className="icon-left" />}
            {title && <span>{t(title)}</span>}
        </a>
    );
};

ImageLink.propTypes = propTypes;
ImageLink.defaultProps = defaultProps;

export default withTagDefaultProps(ImageLink);
