import React, {useCallback} from "react";
import {compose} from "redux";
import {equals} from "ramda";
import connect from 'Hoc/Template/Connect';
import {permissionsEnum} from 'Services/Enums';

const checkPermissions = _permissions => (allowedPermissions) => _permissions.some(r => allowedPermissions.includes(r));

const PermissionsProps = Wrapped => ({ _permissions, _companyId, _userId, ...other }) => {
    const _isMe = useCallback(equals(_userId), []);
    const _checkCompany = useCallback(equals(_companyId), []);
    const _checkPermissions = useCallback(checkPermissions(_permissions), []);

    const isGranted = useCallback((permissions, company = false, _root = true) => {
        if (_root && _checkPermissions(permissionsEnum.admin)) {
            return true;
        }

        if (company && !_checkCompany(company)) {
            return false;
        }

        const arrayPermission = Array.isArray(permissions) ? permissions : [permissions];
        return _checkPermissions(arrayPermission);
    }, []);

    return <Wrapped isGranted={isGranted} isMe={_isMe} {...other} />;
};

const mapStateToProps = state => {
    return {
        _permissions: state.userState.permissions,
        _companyId: state.userState.company,
        _userId: state.userState.id,
    };
};

export default compose(connect(mapStateToProps), PermissionsProps);
