import {compose} from 'redux';
import PropTypes from 'prop-types';
import PermissionsProps from 'Hoc/Template/PermissionsProps';

const defaultProps = {
    allowedCompany: '',
    allowedPermissions: [],
};

const propTypes = {
    isGranted: PropTypes.func.isRequired,
    allowedCompany: PropTypes.string,
    allowedPermissions: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.string),
    ]),
};

const CheckPermission = ({ isGranted, allowedPermissions, allowedCompany, children }) => {
    return isGranted(allowedPermissions, allowedCompany) ? children : null;
};

CheckPermission.defaultProps = defaultProps;
CheckPermission.propTypes = propTypes;

export default compose(PermissionsProps)(CheckPermission);
