import React from 'react';
import PropTypes from 'prop-types';
import { CustomOverlay } from 'Templates/CustomOverlay';
import { Img } from 'Templates/Img';

const propTypes = {
    onClick: PropTypes.func.isRequired,
    isMobile: PropTypes.bool.isRequired,
    sidebarIsOpen: PropTypes.bool.isRequired,
};

const CollapseSidebar = ({ onClick, isMobile, sidebarIsOpen }) => (
    <div className="collapse-sidebar">
        <button type="button" onClick={onClick} className="button button_header">
            <Img img="icon_collapse" alt="collapse btn" />
        </button>
        <CustomOverlay onClick={onClick} show={isMobile ? !sidebarIsOpen : true} />
    </div>
);

CollapseSidebar.propTypes = propTypes;

export default CollapseSidebar;
