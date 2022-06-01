import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img, ImgStorage } from 'Templates/Img';

const propTypes = {
    pref: PropTypes.string.isRequired,
    img: PropTypes.string.isRequired,
};

const AsideLogo = ({ img, pref }) => (
    <div className={`form-info__profile-image form-info__profile-image_${pref}`}>
        {img ? <ImgStorage url={img} alt="aside-logo" /> : <Img img="icon_default-user" alt="aside-logo" />}
    </div>
);

AsideLogo.propTypes = propTypes;

export default withTagDefaultProps(AsideLogo);
