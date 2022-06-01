import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import SidebraLink from './SidebarLink';

const propTypes = {
    label: PropTypes.string.isRequired,
    map: PropTypes.shape({
        link: PropTypes.string.isRequired,
        sublabel: PropTypes.string,
        img: PropTypes.string,
        options: PropTypes.shape({
            [PropTypes.string]: PropTypes.string,
        }),
    }).isRequired,
    service: PropTypes.shape({
        getItemMenuClassName: PropTypes.func.isRequired,
    }).isRequired,
};

const SidebarItem = ({ label, map, service: { getItemMenuClassName } }) => {
    return (
        <li className={`sidebar__item ${getItemMenuClassName(map)}`}>
            <SidebraLink label={label} link={map.link} img={map.img || ''} sublabel={map.sublabel || ''} />
        </li>
    );
};

SidebarItem.propTypes = propTypes;

export default withTagDefaultProps(SidebarItem);
