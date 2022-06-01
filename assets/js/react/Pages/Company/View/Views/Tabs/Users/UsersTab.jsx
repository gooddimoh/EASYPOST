import React from 'react';
import {compose} from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { ServiceProvider } from 'Services/Context';
import { TabBox, TabBoxColumn } from 'Templates/Tabs';
import { IconButton } from 'Templates/Button';
import { url as _url } from 'Services';
import { ask } from 'Widgets/Modal';
import service from '../../../Services/Tabs/Users';
import TableView from '../../TableView';

const propTypes = {
    forceFetch: PropTypes.func.isRequired,
};

const UsersTab = ({ forceFetch }) => {
    const { url, deleteItem } = service;

    const buttons = [
        <IconButton
            key="edit-label"
            title="Edit label"
            icon="icon_edit"
            onClick={({ id }) => _url.redirect(`/${url}/${id}/edit`)}
        />,
        <IconButton
            key="delete-label"
            title="Delete label"
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
            <TabBox>
                <TabBoxColumn>
                    <div className="tab-box__title">total:</div>
                </TabBoxColumn>
            </TabBox>
            <TableView buttons={buttons} />
        </ServiceProvider>
    );
};

UsersTab.propTypes = propTypes;

const mapDispatchToProps = () => {
    const { getActionStore } = service;

    return {
        forceFetch: getActionStore('forceFetch'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(UsersTab);
