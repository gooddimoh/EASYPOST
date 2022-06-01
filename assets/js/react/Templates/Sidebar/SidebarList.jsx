import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    children: PropTypes.node.isRequired,
};

const SidebarList = ({ children }) => {
    return <ul className="sidebar__list">{children}</ul>;
};

SidebarList.propTypes = propTypes;

export default withTagDefaultProps(SidebarList);
