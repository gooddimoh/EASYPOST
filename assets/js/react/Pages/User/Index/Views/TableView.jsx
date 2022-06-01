import React from 'react';
import { compose } from 'ramda';
import { withTagDefaultProps, PermissionsProps } from 'Hoc/Template';
import PropTypes from 'prop-types';
import connect from 'Hoc/Template/Connect';
import { url as _url } from 'Services';
import { ask } from 'Widgets/Modal';
import { InfoUsers } from 'InfoManual';
import { permissionsEnum } from 'Services/Enums';
import { TableWidget } from 'Widgets/Table';
import { TopTitleWrap } from 'Templates/Title';
import { IconButton } from 'Templates/Button';

const propTypes = {
    service: PropTypes.shape({
        deleteItem: PropTypes.func.isRequired,
        url: PropTypes.string.isRequired,
    }).isRequired,
    forceFetch: PropTypes.func.isRequired,
    isGranted: PropTypes.func.isRequired,
};

const TableView = ({ service, forceFetch, isGranted }) => {
    const { deleteItem, url } = service;

    const buttons = [];

    if (isGranted(permissionsEnum.owner))
        buttons.unshift(
            <IconButton
                key="edit-user"
                title="Edit user"
                icon="icon_edit"
                onClick={({ id }) => _url.redirect(`/${url}/${id}/edit`)}
            />,
            <IconButton
                key="delete-user"
                title="Delete user"
                icon="icon_delete"
                onClick={({ id }) => {
                    ask('Do you want to delete the item?', async () => {
                        await deleteItem(`/${url}/${id}/delete`);
                        forceFetch();
                    });
                }}
            />,
        );

    return (
        <>
            <TopTitleWrap title="All users" info={<InfoUsers />} />
            <TableWidget buttons={buttons} />
        </>
    );
};

TableView.propTypes = propTypes;

const mapStateToProps = (state) => {
    return {
        permissions: state.userState.permissions,
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        forceFetch: getActionStore('forceFetch'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps), PermissionsProps)(TableView);
