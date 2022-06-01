import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { TableWidget } from 'Widgets/Table';
import { ask } from 'Widgets/Modal';
import { TopTitleWrap } from 'Templates/Title';
import { InfoCompanies } from 'InfoManual';
import { IconButton } from 'Templates/Button';
import { url as _url } from 'Services';
import { permissionsEnum } from 'Services/Enums';

const propTypes = {
    service: PropTypes.shape({
        deleteItem: PropTypes.func.isRequired,
        url: PropTypes.string.isRequired,
    }).isRequired,
    forceFetch: PropTypes.func.isRequired,
    permissions: PropTypes.arrayOf(PropTypes.string).isRequired,
};

const TableView = ({ service, forceFetch, permissions }) => {
    const { deleteItem, url } = service;

    const buttons = [
        <IconButton
            key="delete-company"
            title="Delete company"
            icon="icon_delete"
            onClick={({ id }) => {
                ask('Do you want to delete the item?', async () => {
                    await deleteItem(`/${url}/${id}/delete`);
                    forceFetch();
                });
            }}
        />,
    ];

    if (permissions.includes(permissionsEnum.admin))
        buttons.unshift(
            <IconButton
                key="edit-company"
                title="Edit company"
                icon="icon_edit"
                onClick={({ id }) => _url.redirect(`/${url}/${id}/edit`)}
            />,
        );

    return (
        <>
            <TopTitleWrap title="Companies" info={<InfoCompanies />} />

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

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(TableView);
