import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { SidebarItem } from 'Templates/Sidebar';
// eslint-disable-next-line import/no-cycle
import SidebarContent from './SidebarContent';

const propTypes = {
    counter: PropTypes.number.isRequired,
    label: PropTypes.string.isRequired,
    map: PropTypes.shape({
        img: PropTypes.string.isRequired,
        childrens: PropTypes.shape({
            [PropTypes.string]: PropTypes.shape({
                link: PropTypes.shape.isRequired,
                sublabel: PropTypes.string,
            }),
        }),
        options: PropTypes.shape({
            [PropTypes.string]: PropTypes.string,
            dropdownActiveClass: PropTypes.string,
        }),
    }).isRequired,
};

class DropdownMenu extends Component {
    constructor(props) {
        super(props);
        const { map } = this.props;
        this.state = {
            showItems: Object.values(map.childrens).some((elem) => window.location.pathname.startsWith(elem.link)),
            itemsHeight: null,
        };

        this.activeElement = React.createRef();
    }

    componentDidMount() {
        const { showItems } = this.state;

        if (showItems) {
            this.activeElement.current.style.transitionDuration = '0s';
            this.setItemsHeight(this.activeElement.current);
        }
    }

    handleClickOnMenuItem = (e) => {
        e.preventDefault();

        this.setState((prevState) => ({
            showItems: !prevState.showItems,
        }));

        const items = e.target.closest('.submenu-item').nextElementSibling;
        items.style.transitionDuration = '0.3s';
        this.setItemsHeight(items);
    };

    setItemsHeight = (items) => {
        this.setState((prevState) => ({
            itemsHeight: prevState.itemsHeight === null ? `${items.scrollHeight}px` : null,
        }));
    };

    render() {
        const { label, map, counter } = this.props;
        const { showItems, itemsHeight } = this.state;
        return (
            <li className={`sidebar__item ${showItems ? map.options.dropdownActiveClass : ''}`}>
                <SidebarItem onClick={this.handleClickOnMenuItem} img={map.img} label={label} />
                <ul
                    style={{ height: itemsHeight }}
                    className={`sidebar__list menu_level_${counter}`}
                    ref={counter ? this.activeElement : null}
                >
                    <SidebarContent counter={counter} map={map.childrens} />
                </ul>
            </li>
        );
    }
}

DropdownMenu.propTypes = propTypes;

export default DropdownMenu;
