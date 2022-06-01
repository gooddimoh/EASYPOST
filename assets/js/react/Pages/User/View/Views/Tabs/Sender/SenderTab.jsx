import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { url as _url } from 'Services';
import { ServiceProvider } from 'Services/Context';
import { ask } from 'Widgets/Modal';
import { TableWidget } from 'Widgets/Table';
import { IconButton } from 'Templates/Button';
import service from '../../../Services/Tabs/Sender';

const propTypes = {
    service: PropTypes.shape({
        deleteItem: PropTypes.func.isRequired,
        url: PropTypes.string.isRequired,
    }).isRequired,
    forceFetch: PropTypes.func.isRequired,
};

const SenderTab = ({ forceFetch }) => {
    const { url, deleteItem } = service;

    const buttons = [
        <IconButton
            key="edit-sender"
            title="Edit sender"
            icon="icon_edit"
            onClick={({ id }) => _url.redirect(`/${url}/${id}/edit`)}
        />,
        <IconButton
            key="delete-sender"
            title="Delete sender"
            icon="icon_delete"
            onClick={({ id }) => {
                ask('Do you want to delete the item?', async () => {
                    await deleteItem(`/${url}/${id}/delete`);
                    forceFetch();
                });
            }}
        />,
    ];

    return (
        <ServiceProvider value={service}>
            <TableWidget buttons={buttons} />
        </ServiceProvider>
    );
};

SenderTab.propTypes = propTypes;

const mapDispatchToProps = () => {
    const { getActionStore } = service;
    return {
        forceFetch: getActionStore('forceFetch'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(SenderTab);
