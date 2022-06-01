import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { debounce } from 'Services/Debounce';
import { ServiceProvider } from 'Services/Context';
import Header from 'App/View/Header';
import Sidebar from 'App/View/Sidebar';
import {ContainerWrap} from 'Templates/Content';
import {Footer} from 'App/View/Footer';

const propTypes = {
    service: PropTypes.shape({
        getStoreItem: PropTypes.func.isRequired,
    }).isRequired,
};

class Content extends Component {
    state = {
        sidebarIsOpen: +localStorage.getItem('SidebarIsOpen'),
        isMobile: window.innerWidth < 1280,
    };

    componentDidMount() {
        window.addEventListener('resize', this.updateDimensions);
    }

    componentWillUnmount() {
        window.removeEventListener('resize', this.updateDimensions);
    }

    updateDimensions = () => {
        debounce(() => {
            const state = {
                isMobile: window.innerWidth < 1280,
            };

            if (state.isMobile) {
                state.sidebarIsOpen = 0;
            }

            this.setState(state);
        }, 200);
    };

    handleClickOnSome = () =>
        // TODO: the function name
        {
            this.setState((prevState) => {
                const sidebarIsOpen = prevState.sidebarIsOpen ? 0 : 1;

                localStorage.setItem('SidebarIsOpen', sidebarIsOpen);

                return {
                    sidebarIsOpen,
                };
            });
        };

    render() {
        const { sidebarIsOpen, isMobile } = this.state;
        const { service, children } = this.props;
        return (
            <div className={`main-wrap__content ${sidebarIsOpen ? 'active-sidebar' : ''}`}>
                <Sidebar onClickOnSome={this.handleClickOnSome} />
                <div className="main-content-wrap">
                    <ServiceProvider value={{ getStoreItem: service.getStoreItem }}>
                        <Header
                            onClickOnSome={this.handleClickOnSome}
                            isMobile={isMobile}
                            sidebarIsOpen={!!sidebarIsOpen}
                        />
                    </ServiceProvider>
                    <div className="main-content">
                        <ContainerWrap>
                            <ServiceProvider value={service}>{children}</ServiceProvider>
                            <Footer />
                        </ContainerWrap>
                    </div>
                </div>
            </div>
        );
    }
}

Content.propTypes = propTypes;

export default Content;
