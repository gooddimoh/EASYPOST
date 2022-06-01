import React from 'react';
import PropTypes from 'prop-types';
import { Img } from 'Templates/Img';

const propTypes = {
    onClick: PropTypes.func.isRequired,
    side: PropTypes.string.isRequired,
};

const ArrowButton = ({ onClick, side }) => {
    return (
        <button type="button" onClick={onClick} className={`main-pagination__arrow main-pagination__arrow_${side}`}>
            <Img img={`paginator-arrow-${side}`} alt={`paginator-arrow-${side}`} />
        </button>
    );
};

ArrowButton.propTypes = propTypes;

export default ArrowButton;
