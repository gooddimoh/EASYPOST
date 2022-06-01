import React from "react";
import PropTypes from "prop-types";
import { compose } from "redux";
import { withTagDefaultProps } from "Hoc/Template";
import assets from "Assets";
import Svg from "./Svg";

const propTypes = {
    img: PropTypes.string.isRequired,
    alt: PropTypes.string,
    className: PropTypes.string,
    width: PropTypes.string,
    height: PropTypes.string,
};

const defaultProps = {
    alt: "",
    className: "",
    width: "",
    height: "",
};

const Img = ({ img, alt, className, width, height }) => {
    const _asset = assets(img);

    if (_asset.viewBox) {
        return <Svg icon={_asset} className={`${img} ${className}`} width={width} height={height} />;
    }

    return <img src={_asset} alt={alt} width={width || ""} height={height || ""} className={className} />;
};

Img.propTypes = propTypes;
Img.defaultProps = defaultProps;

export default compose(withTagDefaultProps)(Img);
