import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import { UserProfile, CollapseSidebar, /* Languages, Separator, ThemeSwitcher, */ Balance } from './Items';
import service from './Service';

const propTypes = {
    onClickOnSome: PropTypes.func.isRequired,
    isMobile: PropTypes.bool.isRequired,
    sidebarIsOpen: PropTypes.bool.isRequired,
};

const Header = ({ onClickOnSome, isMobile, sidebarIsOpen }) => {
    return (
        <ServiceProvider value={service}>
            <header className="header">
                <div className="header__wrap">
                    <div className="header__block">
                        <CollapseSidebar onClick={onClickOnSome} isMobile={isMobile} sidebarIsOpen={sidebarIsOpen} />
                        {/* <ThemeSwitcher /> */}
                        {/* <Languages /> */}
                        {/* <Separator /> */}
                        <UserProfile />
                    </div>

                    <div className="header__balance-row">
                        <Balance />
                    </div>
                </div>
            </header>
        </ServiceProvider>
    );
};

Header.propTypes = propTypes;

export default withTagDefaultProps(Header);
