import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

const propTypes = {
    label: PropTypes.string.isRequired,
    link: PropTypes.string,
    img: PropTypes.string,
    sublabel: PropTypes.string,
    onClick: PropTypes.func,
};

const defaultProps = {
    link: '#',
    img: '',
    sublabel: '',
    onClick: () => {
        const availableScreenWidth = window.screen.availWidth;
        if (availableScreenWidth === 1279) {
            localStorage.removeItem('SidebarIsOpen');
        }
    },
};

const SidebarLink = ({ link, img, sublabel, label, onClick }) => {
    return (
        <a
            href={link}
            onClick={onClick}
            className={`sidebar__link ${link === defaultProps.link ? 'submenu-item' : ''}`}
            data-sublabel={sublabel}
            title={label}
        >
            {img && (
                <span className="sidebar__icon">
                    <Img img={img} alt={label} />
                </span>
            )}
            <span className="sidebar__text">{label}</span>
        </a>
    );
};

SidebarLink.propTypes = propTypes;
SidebarLink.defaultProps = defaultProps;

export default withTagDefaultProps(SidebarLink);
