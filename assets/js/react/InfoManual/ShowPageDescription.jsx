import React, { useRef } from 'react';
import PropTypes from 'prop-types';

const propTypes = {
    children: PropTypes.node.isRequired,
    toggle: PropTypes.bool.isRequired,
};

const ShowPageDescription = ({ children, toggle }) => {
    const ref = useRef(null);
    return (
        <div ref={ref} className="info-manual" style={{ height: toggle ? `${ref.current.scrollHeight}px` : null }}>
            <div className="info-manual__wrap">{children}</div>
        </div>
    );
};

ShowPageDescription.propTypes = propTypes;

export default ShowPageDescription;
