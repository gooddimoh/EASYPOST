import React from 'react';
import PropTypes from 'prop-types';
import { always } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

const propTypes = {
    title: PropTypes.string.isRequired,
    icon: PropTypes.string.isRequired,
    onClick: PropTypes.func.isRequired,
    isShow: PropTypes.func,
    pref: PropTypes.string.isRequired,
};

const defaultProps = {
    isShow: always(true),
};

const IconButton = ({ title, icon, onClick, pref, isShow, t }) => {
    if (!isShow()) return null;
    return (
        <button
            aria-label={title}
            className={`main-circle main-circle_${pref}`}
            type="button"
            title={t(title)}
            onClick={onClick}
        >
            <Img img={icon} alt={title} />
        </button>
    );
};

IconButton.propTypes = propTypes;
IconButton.defaultProps = defaultProps;

export default withTagDefaultProps(IconButton);
