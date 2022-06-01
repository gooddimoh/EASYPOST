import React from 'react';
import PropTypes from 'prop-types';
import { ServiceProvider } from 'Services/Context';
import { Img } from 'Templates/Img';
import { CollapseButton } from 'Templates/Button';
import { Sidebar as Aside, SidebarList } from 'Templates/Sidebar';
import { sidebarItems } from './Config';
import SidebarContent from './View/SidebarContent';
import sidebarService from './Services';

const propTypes = {
    onClickOnSome: PropTypes.func.isRequired,
};

const Sidebar = ({ onClickOnSome }) => {
    return (
        <Aside>
            <a href="/" className="sidebar__logo" title="Postal bridge">
                <span className="sidebar__logo-full">
                    <Img img="logo" alt="logo" />
                </span>
                <span className="sidebar__logo-small">
                    <Img img="logo-small" alt="logo" />
                </span>
            </a>
            <SidebarList>
                <ServiceProvider value={sidebarService}>
                    <SidebarContent map={sidebarItems} />
                </ServiceProvider>
            </SidebarList>

            <CollapseButton onClick={onClickOnSome} />
        </Aside>
    );
};

Sidebar.propTypes = propTypes;

export default Sidebar;
