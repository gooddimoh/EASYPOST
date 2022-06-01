import React from 'react';
import PropTypes from 'prop-types';

const propTypes = {
    icon: PropTypes.objectOf(PropTypes.any).isRequired,
    width: PropTypes.string,
    height: PropTypes.string,
    className: PropTypes.string,
};

const defaultProps = {
    width: '',
    height: '',
    className: '',
};

const Svg = ({ className, icon, width, height }) => {
    const w = width || icon.viewBox.split(' ')[2];
    const h = height || icon.viewBox.split(' ')[3];

    return (
        <svg className={`icon-svg ${className}`} width={w} height={h}>
            <use xlinkHref={icon.url} viewBox={icon.viewBox} />
        </svg>
    );
};

Svg.propTypes = propTypes;
Svg.defaultProps = defaultProps;

export default Svg;
