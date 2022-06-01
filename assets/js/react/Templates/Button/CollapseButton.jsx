import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

const propTypes = {
    onClick: PropTypes.func.isRequired,
    pref: PropTypes.string.isRequired,
};

const CollapseButton = ({ onClick, pref }) => {
    return (
        <button
            aria-label="collapse-btn"
            type="button"
            onClick={onClick}
            className={`collapse-btn collapse-btn_${pref}`}
        >
            <Img img="icon_btn_aside" alt="icon_btn_aside" />
        </button>
    );
};

CollapseButton.propTypes = propTypes;

export default withTagDefaultProps(CollapseButton);
