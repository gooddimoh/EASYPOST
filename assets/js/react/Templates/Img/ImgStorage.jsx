import React from 'react';
import PropTypes from 'prop-types';
import { storagePref } from 'Services';

const propTypes = {
    url: PropTypes.string.isRequired,
    alt: PropTypes.string,
    onLoad: PropTypes.func,
};

const defaultProps = {
    alt: '',
    onLoad: () => {},
};

const ImgStorage = ({ url, alt, onLoad }) => {
    return <img src={`${storagePref}/${url}`} alt={alt} onLoad={onLoad} />;
};

ImgStorage.propTypes = propTypes;
ImgStorage.defaultProps = defaultProps;

export default ImgStorage;
