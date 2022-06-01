import {compose} from "redux";
import PropTypes from "prop-types";
import PermissionsProps from "Hoc/Template/PermissionsProps";

const defaultProps = {
    deniedPermissions: [],
};

const propTypes = {
    isGranted: PropTypes.func.isRequired,
    deniedPermissions: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.string),
    ]),
};

const UnCheckPermission = ({ isGranted, deniedPermissions, children }) => {
    return isGranted(deniedPermissions, false, false) ? null : children;
};

UnCheckPermission.defaultProps = defaultProps;
UnCheckPermission.propTypes = propTypes;

export default compose(
    PermissionsProps,
)(UnCheckPermission);
