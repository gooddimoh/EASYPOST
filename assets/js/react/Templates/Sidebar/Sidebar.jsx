import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    children: PropTypes.node.isRequired,
};

const Sidebar = ({ children }) => {
    return <aside className="sidebar">{children}</aside>;
};

Sidebar.propTypes = propTypes;

export default withTagDefaultProps(Sidebar);
