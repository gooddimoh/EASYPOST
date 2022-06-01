import React from "react";
import PropTypes from "prop-types";
import CheckPermission from "./CheckPermission";
import UnCheckPermission from "./UnCheckPermission";

const defaultProps = {
    permission: "",
    exclude: () => ''
};

const propTypes = {
    permission: PropTypes.string,
    exclude: PropTypes.func
};

const LinkPermission = ({permission, exclude, children}) =>
    <>
        <CheckPermission permission={permission}>
            {children}
        </CheckPermission>
        <UnCheckPermission permission={permission}>
            {exclude}
        </UnCheckPermission>
    </>;

LinkPermission.defaultProps = defaultProps;
LinkPermission.propTypes = propTypes;

export default LinkPermission;
